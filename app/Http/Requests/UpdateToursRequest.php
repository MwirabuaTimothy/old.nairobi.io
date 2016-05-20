<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Http\Response;

class UpdateToursRequest extends Request {
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
			'title' => 'sometimes',
			'description' => 'sometimes',
			'available_from' => 'sometimes|date_format:Y-m-d H:i:s',
			'available_to' => 'sometimes|date_format:Y-m-d H:i:s',
			'image' => 'sometimes|mimes:jpeg,jpg,png',
			'rate' => 'sometimes',
			'rules' => 'sometimes',
		];
	}
	public function response(array $errors) {
		// return $errors;
		return Response::create(error($errors), 403);
	}
}
