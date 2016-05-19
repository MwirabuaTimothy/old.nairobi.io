<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

use App\Tour;

class ToursController extends Controller 
{
	public function __construct(Response $response)
	{
		$this->response = $response;
	}
	public function getTours() {
		$tours = Tour::all();
		return $tours;
		// return success('Listing all tours', 'tours', $tours);
	}

}
