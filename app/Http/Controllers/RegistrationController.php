<?php

namespace App\Http\Controllers;
use App\Models\Access\User\User;
use Auth;
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
		// GET /v2.6/{user-id} HTTP/1.1
		$user = Socialite::driver('facebook')->fields(['first_name', 'last_name', 'email', 'gender', 'birthday', 'about', 'bio', 'education', 'hometown', 'location', 'work'])->user();
		//dd($user);
		$last_sch = $user->user['education'][count($user->user['education']) - 1];

		return $last_sch['school']['name'];

		$existing_user = User::where('email', $user->email)->first();

		if ($existing_user === null) {

			$existing_user = User::create([
				'first_name' => $user->user['first_name'],
				'last_name' => $user->user['last_name'],
				'email' => $user->user['email'],
				'gender' => $user->user['gender'],
				'fb_uid' => $user->user['id'],
				'dob' => $user->user['birthday'],
				'about' => $user->user['about'],
				'bio' => $user->user['bio'],
				'hometown' => $user->user['hometown']['name'],
				'current_city' => $user->user['location']['name'],
				'education_institution' => $last_sch['school']['name'],
				'image' => $user->avatar,
			]);
		}
		$existing_user->first_name = $separate_name[0];
		$existing_user->last_name = $separate_name[1];

		Auth::login($existing_user);
		return "loged in";
	}

	//return redirect()->to('/')->;

}
