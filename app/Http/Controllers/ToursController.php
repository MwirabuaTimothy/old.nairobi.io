<?php

namespace App\Http\Controllers;
use App\Tour;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;

//fd96988c8f2a2dfd53cbbd7d10a5fb5f00031f22
class ToursController extends ApiGuardController {
	public function getTours() {
		$tours = Tour::all();
		//return $this->response->withCollection($tours);
		return $this->response->withArray(['data' => $tours->toArray()]);
		if (!$tours) {
			throw new Exception("No tours to display");

		}
	}

}
