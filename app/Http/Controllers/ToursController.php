<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

use App\Tour;

class ToursController extends Controller 
{
	public function __construct(Request $request, Response $response)
	{
		$this->request = $request;
		$this->response = $response;
	}
	public function getTours() {
		// return $this->request;
		// return $this->request->api_token;
		// return bcrypt($this->request->api_token);
		$tours = Tour::all();
		return $tours;
		// return success('Listing all tours', 'tours', $tours);
	}

}
