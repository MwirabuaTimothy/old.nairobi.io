<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToursRequest;
use App\Tour;
use Auth;
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
	public function create(ToursRequest $request) {
		$input_data = $request->all();
		//dd($input_data);

		if (!$input_data) {
			return error('No data Input!');
		}
		$image = $input_data['image']; //getting image

		$destinationPath = 'tours/image'; // upload path
		$extension = $image->getClientOriginalExtension();

		//give file a microtime name, limit name to 12 characters
		$fileName = substr(microtime(true) * 100, 0, 12) . '.' . $extension;

		//move file to folder
		$image->move($destinationPath, $fileName);

		$user = Auth::user()->id; //logged in user
		//dd($user);
		$existing_tour = Tour::where('title', $input_data['title'])->where('user_id', $user)->first();
		if ($existing_tour === null) {

			$tour = new Tour;
			$tour->title = $input_data['title'];
			$tour->description = $input_data['description'];
			$tour->user_id = $user;
			$tour->available_from = $input_data['available_from'];
			$tour->available_to = $input_data['available_to'];
			$tour->image = $destinationPath . '/' . $fileName;
			$tour->rate = $input_data['rate'];
			$tour->rules = $input_data['rules'];

			$tour->save();
			if (!$tour->save()) {

				return error('Could not create a new tour!', 'tours/create');

			}
			return success('Successfully created the tour', 'tours', $tour);

		}
		return error('You have a tour by the same name!', 'tours/create');

	}

	public function show($id) {
		$tour = Tour::firstOrFail($id);
		if (!$tour) {
			return error('The tour does not exist!');
		}
		return $tour;
	}
	public function update(ToursRequest $request, $id) {
		$input_data = $request->all();

		//dd($input_data['image']);
		$image = $input_data['image']; //getting image

		$destinationPath = 'tours/image'; // upload path
		$extension = $image->getClientOriginalExtension();

		//give file a microtime name, limit name to 12 characters
		$fileName = substr(microtime(true) * 100, 0, 12) . '.' . $extension;

		//move file to folder
		$image->move($destinationPath, $fileName);
		$tour = Tour::findOrFail($id);
		$tour->update([
			'title' => $input_data['title'],
			'description' => $input_data['description'],
			'available_from' => $input_data['available_from'],
			'available_to' => $input_data['available_to'],
			'image' => $destinationPath . '/' . $fileName,
			'rate' => $input_data['rate'],
			'rules' => $input_data['rules'],

		]);
		if ($tour) {
			return success('Succesfully updated your tour', 'tours', $tour);
		}
	}
	public function destroy($id) {
		$tour = Tour::findOrFail($id);
		$tour->delete();
		if ($tour) {
			return success('Tour deleted', 'tours');
		}
	}

}
