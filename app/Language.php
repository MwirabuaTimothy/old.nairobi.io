<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
	 */
	public function user() {
		return $this->belongsToMany('App\User');
	}

}
