<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function messages() {
		return $this->hasMany('\App\Message');
	}
}
