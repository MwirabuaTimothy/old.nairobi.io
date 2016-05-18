<?php

namespace App;

use Chrisbjr\ApiGuard\Models\ApiKey as PackageKey;

class ApiKey extends PackageKey {
	protected $table = 'api_keys';
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
	public function getApiKey() {

		$salt = sha1(time() . mt_rand());
		$newKey = substr($salt, 0, 40);
		// Already in the DB? Fail. Try again

		return $newKey;
	}
/**
 * @return \Illuminate\Database\Eloquent\Relations\hasOne
 */
	public function user() {
		return $this->belongsTo('\App\Models\Access\User\User');
	}
}
