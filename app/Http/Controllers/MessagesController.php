<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MessagesController extends Controller
{
    public function index() {
		$messages = \App\Message::all();
		return $messages;
	}
}
