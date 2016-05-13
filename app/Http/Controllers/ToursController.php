<?php

namespace App\Http\Controllers;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;

//fd96988c8f2a2dfd53cbbd7d10a5fb5f00031f22
class ToursController extends ApiGuardController {
	public function getTours() {
		$tours = Tours::all();
		return $this->response->withCollection($tours);
	}
}
