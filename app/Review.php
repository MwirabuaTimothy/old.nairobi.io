<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function tour() {
		return $this->belongsTo('\App\Tour');
	}
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function user() {
		return $this->belongsTo('\App\Models\Access\User\User');
	}

}
