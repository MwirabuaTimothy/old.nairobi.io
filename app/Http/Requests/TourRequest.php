<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TourRequest extends Request {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return false;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'title' => 'required',
			'description' => 'required',
			'available_from' => 'required',
			'available_to' => 'required',
			'image' => 'required|mimes:jpeg,jpg,png',
			'rate' => 'required',
			'rules' => 'required',
			//
		];
	}
}
