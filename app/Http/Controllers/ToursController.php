<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Tour;

//fd96988c8f2a2dfd53cbbd7d10a5fb5f00031f22
class ToursController {
	public function getTours() {
		$tours = Tour::all();
		//return $this->response->withCollection($tours);
		return $this->response->withArray(['data' => $tours->toArray()]);
		if (!$tours) {
			throw new Exception("No tours to display");

		}
	}

}
