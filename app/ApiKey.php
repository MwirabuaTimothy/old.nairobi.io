<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Chrisbjr\ApiGuard\Models\ApiKey as PackageKey;

class ApiKey extends PackageKey(){
	public static function getUsersKey($user_id) {
		$api_obj = ApiKey::where('user_id', $user_id)->first(['key']);

		// Create Key if none exists.
		if ($api_obj === null) {
			$api_obj = new ApiKey;
			$api_obj->user_id = $user_id;
			$api_obj->key = $api_obj->generateKey();
			$api_obj->level = 5;
			$api_obj->save();
		}

		return $api_obj !== null ? $api_obj['key'] : null;
	}
}
