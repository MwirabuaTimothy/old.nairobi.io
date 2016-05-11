<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {
/**
 * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
 */
	public function tour() {
		return $this->belongsToMany('\App\Tour', 'user_languages');
	}
}
