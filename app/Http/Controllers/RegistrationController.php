<?php

namespace App\Http\Controllers;
use App\Http\Requests\FacebookMobile;
use App\Models\Access\User\User;
use Auth;
use Illuminate\Http\Request;
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
			$existing_user->api_token =
			$existing_user->current_city = $user->user['location']['name'];
			$existing_user->education_institution = $last_sch['school']['name'];
			$existing_user->image = $user->avatar;

			$existing_user->save();
		}

		Auth::login($existing_user);
		return redirect('/');
	}
	/**
	 * @param FacebookMobile $request
	 * @return mixed
	 */
	// public function apiRegistration(FacebookMobile $request){

	public function apiRegistration(Request $request) {

		$r = $request->json()->all();
		// return $r;

		// @todo validate request parameters
		// required - gcm, device, platform, version, first_name, lastname, email, gender, fb_uid, birthday, bio

		if (!empty($r)) {

			$arr = [];
			$arr['api_token'] = bcrypt(md5(microtime())); // create the token;

			!isset($r['gcm']) ?: $arr['gcm'] = $r['gcm'];
			!isset($r['device']) ?: $arr['device'] = $r['device'];
			!isset($r['platform']) ?: $arr['platform'] = $r['platform'];
			!isset($r['version']) ?: $arr['version'] = $r['version'];

			// return $arr;

			if ($user = User::where('email', $r['email'])->first()) {
				$user->update($arr);
			} else {
				// create user from the posted data

				!isset($r['first_name']) ?: $arr['first_name'] = $r['first_name'];
				!isset($r['last_name']) ?: $arr['last_name'] = $r['last_name'];
				!isset($r['email']) ?: $arr['email'] = $r['email'];
				!isset($r['gender']) ?: $arr['gender'] = $r['gender'];
				!isset($r['fb_uid']) ?: $arr['fb_uid'] = $r['fb_uid'];
				!isset($r['birthday']) ?: $arr['dob'] = date("Y-m-d", strtotime($r['birthday']));
				!isset($r['bio']) ?: $arr['bio'] = $r['bio'];
				!isset($r['avatar']) ?: $arr['image'] = $r['avatar'];
				!(isset($r['hometown']) && isset($r['hometown']['name'])) ?: $arr['hometown'] = $r['hometown']['name'];
				!(isset($r['location']) && isset($r['location']['name'])) ?: $arr['current_city'] = $r['location']['name'];
				if (isset($r['education'])) {
					$l = $last_sch = $r['education'][count($r['education']) - 1];
				}
				!(isset($l['school']) && isset($l['school']['name'])) ?: $arr['education_institution'] = $l['school']['name'];

				// return $arr;

				$user = User::create($arr);
			}
			Auth::login($user); // log in the user
			$request->api_token = $arr['api_token'];
			return $user;
		} else {
			// return ['success'=>false, 'error'=>'Send a json object!'];
			return error('Send a valid json object!');
		}
		// @todo log the login
	}

}
