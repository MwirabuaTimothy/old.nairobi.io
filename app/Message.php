<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function user() {
		return $this->belongsTo('\App\Models\Access\User\User');
	}
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function booking() {
		return $this->belongsTo('\App\Booking');
	}

}
