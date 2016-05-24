<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model {
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function tag() {
		return $this->hasMany('\App\Tag');
	}
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function user() {
		return $this->belongsTo('\App\Models\Access\User\User');
	}

}
