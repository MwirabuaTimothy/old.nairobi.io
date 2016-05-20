<?php

namespace App\Http\Controllers;

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
	public function create() {
		$input_data = $this->request->all();
		//dd($input_data);

		if (!$input_data) {
			return 'No data Input';
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

			$existing_tour = new Tour;
			$existing_tour->title = $input_data['title'];
			$existing_tour->description = $input_data['description'];
			$existing_tour->user_id = $user;
			$existing_tour->available_from = $input_data['available_from'];
			$existing_tour->available_to = $input_data['available_to'];
			$existing_tour->image = $destinationPath . '/' . $fileName;
			$existing_tour->rate = $input_data['rate'];
			$existing_tour->rules = $input_data['rules'];

			$existing_tour->save();
			if (!$existing_tour->save()) {
				return 'Could not create a new tour';

			}
			return 'successfully created a new tour';

		}
		return 'You already created the same tour';

	}

	public function show($id) {
		$tour = Tour::where('id', $id)->first();
		if ($tour) {
			return 'No such tour';
		}
		return $tour;
	}
	public function update($id) {
		$input_data = $this->request->all();
		//dd($input_data);
		$image = $input_data['image']; //getting image

		$destinationPath = 'tours/image'; // upload path
		$extension = $image->getClientOriginalExtension();

		//give file a microtime name, limit name to 12 characters
		$fileName = substr(microtime(true) * 100, 0, 12) . '.' . $extension;

		//move file to folder
		$image->move($destinationPath, $fileName);
		$tour = Tour::find($id)->update([
			'title' => $input_data['title'],
			'description' => $input_data['description'],
			'available_from' => $input_data['available_from'],
			'available_to' => $input_data['available_to'],
			'image' => $destinationPath . '/' . $fileName,
			'rate' => $input_data['rate'],
			'rules' => $input_data['rules'],

		]);
		if ($tour) {
			return ['success' => true, 'message' => 'Succesfully updated your tour'];
		}
	}
	public function destroy($id) {
		$tour = Tour::find($id)->delete();
		if ($tour) {
			return ['success' => true, 'message' => 'Tour deleted'];
		}
	}

}
