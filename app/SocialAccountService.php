<?php

namespace App;

use App\Models\Access\User\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService {
	public function createOrGetUser(ProviderUser $providerUser) {
		$user = User::whereEmail($providerUser->getEmail())->first();

		$separate_name = explode(" ", $providerUser->getName());
		if (!$user) {

			$user = User::create([
				'fb_uid' => $providerUser->getId(),
				'email' => $providerUser->getEmail(),
				'email' => $providerUser->getEmail(),
				'first_name' => $separate_name[0],
				'last_name' => $separate_name[1],
			]);
		} elseif ($user) {
			$user->fb_uid = $providerUser->getId();
			$user->email = $providerUser->getEmail();
			$user->first_name = $separate_name[0];
			$user->last_name = $separate_name[1];
		}

		return $user;

	}

}