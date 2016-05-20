<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Http\Response;

class ToursRequest extends Request {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
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
			'available_from' => 'required|date_format:Y-m-d H:i:s',
			'available_to' => 'required|date_format:Y-m-d H:i:s',
			'image' => 'required|mimes:jpeg,jpg,png',
			'rate' => 'required',
			'rules' => 'required',
		];
	}
	public function response(array $errors) {
		// return $errors;
		return Response::create(error($errors), 403);
	}
}
