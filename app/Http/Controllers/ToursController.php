<?php

namespace App\Http\Controllers;

use App\Tour;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ToursController extends Controller {
	public function __construct(Request $request, Response $response) {
		$this->request = $request;
		$this->response = $response;
	}

	public function index() {
		// return $this->request;
		// return $this->request->api_token;
		// return bcrypt($this->request->api_token);
		$tours = Tour::all();
		return $tours;
		// return success('Listing all tours', 'tours', $tours);
	}
	public function create(Request $request) {
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
