<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
	 */
	public function users() {
		return $this->belongsToMany('\App\Models\Access\User\User', 'user_languages');
	}

}
