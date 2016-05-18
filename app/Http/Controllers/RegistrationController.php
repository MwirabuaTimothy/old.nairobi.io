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

	public function facebook() {
		// when facebook call us a with token

		$user = Socialite::driver('facebook')->fields(['first_name', 'last_name', 'email', 'gender', 'birthday', 'about', 'bio', 'education', 'hometown', 'location', 'work'])->user();
		//dd(date("Y-m-d", strtotime($user->user['birthday'])));
		$last_sch = $user->user['education'][count($user->user['education']) - 1];

		$existing_user = User::where('email', $user->email)->first();

		if ($existing_user === null) {

			$existing_user = new User;
			$existing_user->first_name = $user->user['first_name'];
			$existing_user->last_name = $user->user['last_name'];
			$existing_user->email = $user->user['email'];
			$existing_user->gender = $user->user['gender'];
			$existing_user->fb_uid = $user->user['id'];
			$existing_user->dob = date("Y-m-d", strtotime($user->user['birthday']));
			$existing_user->bio = $user->user['bio'];
			$existing_user->hometown = $user->user['hometown']['name'];
			$existing_user->current_city = $user->user['location']['name'];
			$existing_user->education_institution = $last_sch['school']['name'];
			$existing_user->image = $user->avatar;
			//'api_key' => $new_token->getApiKey(),
			$existing_user->save();
		}
		$token = ApiKey::where('user_id', $existing_user->id)->first();
		if ($token === null) {
			$token = new ApiKey;
			$token->key = $token->getApiKey();
			$token->user_id = $existing_user->id;
			$token->save();

		}

		$token->key = $token->getApiKey();
		//$token->user_id = $existing_user->id;
		$token->save();

		Auth::login($existing_user);
		return redirect('/');
	}

	//return redirect()->to('/')->;

}
