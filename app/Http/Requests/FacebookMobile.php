<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Http\Response;

class FacebookMobile extends Request
// class FacebookMobile extends JSONRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // eval(\Psy\sh());
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // eval(\Psy\sh());
        return [
            'fb_uid'                =>  'required',
            'first_name'            =>  'required',
            'last_name'             =>  'required',
            'gender'                =>  'required',
            'email'                 =>  'required|email',
            'image'                 =>  'required',
        ];
    }
    public function response(array $errors) {
        // return $errors;
        return Response::create(error($errors), 403);
    }
}
