<?php

/**
 * API Version 1
 */

Route::group(['prefix' => 'api/v1'], function () {
	
	Route::post('/account/facebook', ['uses' => 'RegistrationController@apiRegistration', 'as' => 'api-reg.fb']);
	
	Route::group(['middleware' => 'APIV1'], function () {

		Route::group(['prefix' => 'tours'], function () {
			Route::get('/', ['uses' => 'ToursController@getTours', 'as' => 'tours']);
		});
		Route::group(['prefix' => 'messages'], function () {
			Route::get('/', ['uses' => 'MessagesController@index', 'as' => 'messages']);
		});
		// Route::get('test', ['uses' => function(Request $request) {
		// 	return $request->user;
		// }, 'as' => 'test']);
		// Route::get('test', ['uses' => function() {
		// 	return auth()->user();
		// }, 'as' => 'test']);
	});
});


/**
 * Testing controller
 */
$router->controller('tests', 'TestsController');

<<<<<<< HEAD
Route::group(['prefix' => 'api/v1'], function () {
	Route::post('create/tour', ['uses' => 'ToursController@createTour', 'as' => 'create_tour']);

	// Route::post('create/tour', ['uses' => 'ToursController@createTour', 'as' => 'create_tour']);
	Route::get('tours', ['uses' => 'ToursController@getTours', 'as' => 'tours']);
});
=======

>>>>>>> e69194d4aab1732fc771cf5f5545a3d11fe49b51
Route::group(['middleware' => 'web'], function () {

	Route::get('redirect', ['uses' => 'RegistrationController@redirect', 'as' => 'redirect']);
	Route::get('account/facebook', ['uses' => 'RegistrationController@facebook', 'as' => 'facebook']);

<<<<<<< HEAD
=======

>>>>>>> e69194d4aab1732fc771cf5f5545a3d11fe49b51
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
		Route::get('/', 'FrontendController@index')->name('frontend.index');
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
