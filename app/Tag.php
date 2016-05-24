<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function post() {
		return $this->belongsTo('\App\Blog');
	}

}
