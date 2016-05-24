<?php
/**
 * API Version 1
 */

Route::group(['prefix' => 'api/v1'], function () {

	// Route::post('/account/facebook', ['uses' => function(Request $request) {
	// 	return $request->json()->all();
	// }, 'as' => 'api-reg.fb']);
	Route::post('/account/facebook', ['middleware' => 'JsonApiMiddleware',
		'uses' => 'RegistrationController@apiRegistration', 'as' => 'api-reg.fb']);

	Route::group(['middleware' => 'APIV1'], function () {

		Route::group(['prefix' => 'tours'], function () {
			Route::get('/', ['uses' => 'ToursController@index', 'as' => 'tours.api']);
			Route::post('/', ['uses' => 'ToursController@create', 'as' => 'tour.create.api']);
			Route::get('/{tour_id}', ['uses' => 'ToursController@show', 'as' => 'tour.show.api']); // @todo - change to slug
			Route::post('{tour_id}', ['uses' => 'ToursController@update', 'as' => 'tour.update.api']);
			Route::get('/{tour_id}/delete', ['uses' => 'ToursController@destroy', 'as' => 'tour.delete.api']);
		});
		Route::group(['prefix' => 'messages'], function () {
			Route::get('/', ['uses' => 'MessagesController@index', 'as' => 'messages']);
		});
		// Route::get('test', ['uses' => function(Request $request) {
		// 	return $request->user;
		// }, 'as' => 'test']);
		Route::get('test', ['uses' => function () {
			return auth()->user();
		}, 'as' => 'test']);
	});
});

/**
 * Testing controller
 */
$router->controller('tests', 'TestsController');

/**
 * Tours resource
 */
$router->resource('tours', 'ToursController');

Route::group(['middleware' => 'web'], function () {
	Route::get('account/facebook/api', ['uses' => 'RegistrationController@redirect', 'as' => 'facebook.redirect']);
	Route::get('account/facebook', ['uses' => 'RegistrationController@facebook', 'as' => 'facebook']);

	/**
	 * Switch between the included languages
	 * Sets the specified locale to the session
	 */
	Route::get('lang/{lang}', 'LanguageController@swap');

	/**
	 * Frontend Routes
	 * Namespaces indicate folder structure
	 */
	Route::group(['namespace' => 'Frontend'], function () {

		/**
		 * Frontend Controllers
		 */
		Route::get('/', 'FrontendController@home')->name('frontend.home');	
		Route::get('macros', 'FrontendController@macros')->name('frontend.macros');

		/**
		 * These frontend controllers require the user to be logged in
		 */
		Route::group(['middleware' => 'auth'], function () {
			Route::group(['namespace' => 'User'], function () {
				Route::get('dashboard', 'DashboardController@index')->name('frontend.user.dashboard');
				Route::get('profile/edit', 'ProfileController@edit')->name('frontend.user.profile.edit');
				Route::patch('profile/update', 'ProfileController@update')->name('frontend.user.profile.update');
			});
		});

		/**
		 * Frontend Access Controllers
		 */
		Route::group(['namespace' => 'Auth'], function () {

			/**
			 * These routes require the user to be logged in
			 */
			Route::group(['middleware' => 'auth'], function () {
				Route::get('logout', 'AuthController@logout')->name('auth.logout');

				// Change Password Routes
				Route::get('password/change', 'PasswordController@showChangePasswordForm')->name('auth.password.change');
				Route::post('password/change', 'PasswordController@changePassword')->name('auth.password.update');
			});

			/**
			 * These routes require the user NOT be logged in
			 */
			Route::group(['middleware' => 'guest'], function () {
				// Authentication Routes
				Route::get('login', 'AuthController@showLoginForm')
					->name('auth.login');
				Route::post('login', 'AuthController@login');

				// Socialite Routes
				Route::get('login/{provider}', 'AuthController@loginThirdParty')
					->name('auth.provider');

				// Registration Routes
				Route::get('register', 'AuthController@showRegistrationForm')
					->name('auth.register');
				Route::post('register', 'AuthController@register');

				// Confirm Account Routes
				Route::get('account/confirm/{token}', 'AuthController@confirmAccount')
					->name('account.confirm');
				Route::get('account/confirm/resend/{user_id}', 'AuthController@resendConfirmationEmail')
					->name('account.confirm.resend');

				// Password Reset Routes
				Route::get('password/reset/{token?}', 'PasswordController@showResetForm')
					->name('auth.password.reset');
				Route::post('password/email', 'PasswordController@sendResetLinkEmail');
				Route::post('password/reset', 'PasswordController@reset');
			});
		});

		# Blog Management
		Route::group(array('prefix' => 'blog'), function(){

			Route::get('/',  ['as'=>'blog.home', 'uses' => 'BlogsController@index']);

			Route::get('api', function(){ return Article::paginate(10); });
			Route::get('create',  ['as'=>'blog.create', 'uses' => 'BlogsController@create']);
			Route::get('search', ['as'=>'blog.search.empty', 'uses'=>'BlogsController@emptySearch']);
			Route::post('search', ['as'=>'blog.search', 'uses'=>'BlogsController@search']);
			Route::get('search/{query}', ['as'=>'blog.search.get', 'uses'=>'BlogsController@getSearch']);
			Route::get('search/api', ['as'=>'blog.search.api', 'uses'=> function(){ return All::ajaxByLetters(); }]);

			Route::get('{id}/highlight', array('as' => 'blog.highlight', 'uses' => 'BlogsController@highlight'));
			Route::get('{id}/top', array('as' => 'blog.top', 'uses' => 'BlogsController@top'));
			Route::get('{id}/api', ['as'=>'article.show.api', 'uses'=>'BlogsController@show']);


			Route::get('{slug}', array('as' => 'blog.show', 'uses' => 'BlogsController@show'));
			Route::get('{slug}/edit', array('as' => 'blog.edit', 'uses' => 'BlogsController@edit'));
			Route::get('{slug}/star', array('as' => 'blog.star', 'uses' => 'BlogsController@star'));
			Route::get('{slug}/unstar', array('as' => 'blog.unstar', 'uses' => 'BlogsController@unstar'));
			Route::post('{slug}', array('as' => 'blog.update', 'uses' => 'BlogsController@update'));

		});


		Route::resource('blog', 'BlogsController');


		Route::get('highlights/api', ['as'=>'article.highlights.api', 'uses'=>'BlogsController@highlights']);


		# Tags Management

		Route::get('tags/api', function(){
			// return Tag::usage();
			return Tag::paginate(30);
		});
		Route::get('tags/{id}/api', function($id){
			// return Tag::find($id);
			return Tag::find($id)->articles;
		});
		Route::get('tagged/{name}/api', function($name){
			return Tag::where('name', $name)->first()->articles;
		});

		Route::resource('tags', 'TagsController');
		Route::get('tagged/{slug}', ['as'=>'tags.show', 'uses'=>'TagsController@show']); // overriding default url structure





	});
});

/**
 * Backend Routes
 * Namespaces indicate folder structure
 * Admin middleware groups web, auth, and routeNeedsPermission
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
	/**
	 * These routes need view-backend permission
	 * (good if you want to allow more than one group in the backend,
	 * then limit the backend features by different roles or permissions)
	 *
	 * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
	 */
	Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');

	Route::group([
		'prefix' => 'access',
		'namespace' => 'Access',
		'middleware' => 'access.routeNeedsPermission:view-access-management',
	], function () {
		/**
		 * User Management
		 */
		Route::group(['namespace' => 'User'], function () {
			Route::resource('users', 'UserController', ['except' => ['show']]);

			Route::get('users/deactivated', 'UserController@deactivated')->name('admin.access.users.deactivated');
			Route::get('users/deleted', 'UserController@deleted')->name('admin.access.users.deleted');
			Route::get('account/confirm/resend/{user_id}', 'UserController@resendConfirmationEmail')->name('admin.account.confirm.resend');

			/**
			 * Specific User
			 */
			Route::group(['prefix' => 'user/{id}', 'where' => ['id' => '[0-9]+']], function () {
				Route::get('delete', 'UserController@delete')->name('admin.access.user.delete-permanently');
				Route::get('restore', 'UserController@restore')->name('admin.access.user.restore');
				Route::get('mark/{status}', 'UserController@mark')->name('admin.access.user.mark')->where(['status' => '[0,1]']);
				Route::get('password/change', 'UserController@changePassword')->name('admin.access.user.change-password');
				Route::post('password/change', 'UserController@updatePassword')->name('admin.access.user.change-password');
			});
		});

		/**
		 * Role Management
		 */
		Route::group(['namespace' => 'Role'], function () {
			Route::resource('roles', 'RoleController', ['except' => ['show']]);
		});

		/**
		 * Permission Management
		 */
		Route::group(['prefix' => 'roles', 'namespace' => 'Permission'], function () {
			Route::resource('permission-group', 'PermissionGroupController', ['except' => ['index', 'show']]);
			Route::resource('permissions', 'PermissionController', ['except' => ['show']]);

			Route::group(['prefix' => 'groups'], function () {
				Route::post('update-sort', 'PermissionGroupController@updateSort')->name('admin.access.roles.groups.update-sort');
			});
		});
	});

	/**
	 * This overwrites the Log Viewer Package routes so we can use middleware to protect it the way we want
	 * You shouldn't have to change anything
	 */
	Route::group([
		'prefix' => 'log-viewer',
	], function () {
		Route::get('/', [
			'as' => 'log-viewer::dashboard',
			'uses' => '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@index',
		]);

		Route::group([
			'prefix' => 'logs',
		], function () {
			Route::get('/', [
				'as' => 'log-viewer::logs.list',
				'uses' => '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@listLogs',
			]);
			Route::delete('delete', [
				'as' => 'log-viewer::logs.delete',
				'uses' => '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@delete',
			]);
		});

		Route::group([
			'prefix' => '{date}',
		], function () {
			Route::get('/', [
				'as' => 'log-viewer::logs.show',
				'uses' => '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@show',
			]);
			Route::get('download', [
				'as' => 'log-viewer::logs.download',
				'uses' => '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@download',
			]);
			Route::get('{level}', [
				'as' => 'log-viewer::logs.filter',
				'uses' => '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@showByLevel',
			]);
		});
	});
});
