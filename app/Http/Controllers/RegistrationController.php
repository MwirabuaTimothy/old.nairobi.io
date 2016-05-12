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
		return Socialite::driver('facebook')->redirect();
	}

	public function callback() {
		// when facebook call us a with token
		$user = Socialite::driver('facebook')->user();
		$existing_user = User::where('email', $user->email)->first();
		$separate_name = explode(" ", $user->name);
		if ($existing_user === null) {

			$existing_user = User::create([
				'fb_uid' => $user->id,
				'email' => $user->email,
				'gender' => $user['gender'],
				'first_name' => $separate_name[0],
				'last_name' => $separate_name[1],
			]);
		}
		$existing_user->first_name = $separate_name[0];
		$existing_user->last_name = $separate_name[1];

		Auth::login($existing_user);
		return "loged in";
	}

	//return redirect()->to('/')->;

}
