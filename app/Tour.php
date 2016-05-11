<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model {

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function users() {
		return $this->belongsTo('\App\Models\Access\User\User');
	}
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
	 */
	public function activities() {
		return $this->belongsToMany('\App\Activity', 'tour_activities');
	}
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function reviews() {
		return $this->hasMany('\App\Review');
	}

}
