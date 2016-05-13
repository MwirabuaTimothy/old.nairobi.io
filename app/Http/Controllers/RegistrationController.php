<?php

namespace App\Http\Controllers;
use App\Models\Access\User\User;
use Auth;
use Chrisbjr\ApiGuard\Models\ApiKey;
use Laravel\Socialite\Facades\Socialite;

class RegistrationController extends Controller {
	/**
	 * [redirect to the facebook auth]
	 * @return [type] [description]
	 */
	public function redirect() {
		return Socialite::driver('facebook')->fields(['first_name', 'last_name', 'email', 'gender', 'birthday', 'about', 'bio', 'education', 'hometown', 'location', 'work'])->redirect();
	}

	public function callback() {
		// when facebook call us a with token

		$user = Socialite::driver('facebook')->fields(['first_name', 'last_name', 'email', 'gender', 'birthday', 'about', 'bio', 'education', 'hometown', 'location', 'work'])->user();
		//dd(date("Y-m-d", strtotime($user->user['birthday'])));
		$last_sch = $user->user['education'][count($user->user['education']) - 1];

		$existing_user = User::where('email', $user->email)->first();
		$new_token = new ApiKey;
		if ($existing_user === null) {

			$existing_user = User::create([
				'first_name' => $user->user['first_name'],
				'last_name' => $user->user['last_name'],
				'email' => $user->user['email'],
				'gender' => $user->user['gender'],
				'fb_uid' => $user->user['id'],
				'dob' => date("Y-m-d", strtotime($user->user['birthday'])),
				'bio' => $user->user['bio'],
				'hometown' => $user->user['hometown']['name'],
				'current_city' => $user->user['location']['name'],
				'education_institution' => $last_sch['school']['name'],
				'image' => $user->avatar,
				'api_key' => $new_token->getApiKey(),
			]);
			// if ($existing_user->save()) {
			// 	$new_token = new ApiKey;
			// 	$new_token->api_key = $new_token->getApiKey();
			// 	$new_token->user_id = $existing_user->id;
			// }
		}

		Auth::login($existing_user);
		return redirect('/');
	}

	//return redirect()->to('/')->;

}
