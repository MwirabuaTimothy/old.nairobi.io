<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

use App\Tour;
<<<<<<< HEAD
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Illuminate\Http\Request;

//fd96988c8f2a2dfd53cbbd7d10a5fb5f00031f22
class ToursController extends ApiGuardController {
	public function __construct(Response $response) {
		$this->response = $response;
	}

=======

class ToursController extends Controller 
{
	public function __construct(Response $response)
	{
		$this->response = $response;
	}
>>>>>>> e69194d4aab1732fc771cf5f5545a3d11fe49b51
	public function getTours() {
		$tours = Tour::all();
		return $tours;
		// return success('Listing all tours', 'tours', $tours);
	}
	public function createTour(Request $request) {
		$input_data = $request->all();
		//dd($input_data);

		if (!$input_data) {
			return $this->response->errorNotFound('No data Input');
		}
		$existing_tour = Tour::where('title', $input_data['title'])->first();
		if ($existing_tour === null) {

			$existing_tour = new Tour;
			$existing_tour->title = $input_data['title'];
			$existing_tour->description = $input_data['description'];
			//$existing_tour->user_id = Auth::user()->id;
			$existing_tour->available_from = $input_data['available_from'];
			$existing_tour->available_to = $input_data['available_to'];
			$existing_tour->image = $input_data['image'];
			$existing_tour->rate = $input_data['rate'];
			$existing_tour->rules = $input_data['rules'];

			$existing_tour->save();
			if (!$existing_tour->save) {
				return $this->response->errorNotFound('Could not create a new tour');

			}

		}

	}

}
