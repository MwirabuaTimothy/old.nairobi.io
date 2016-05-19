<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use \App\Models\Access\User\User;

/**
 * Class APIV1
 * @package App\Http\Middleware
 */

class APIV1 {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */

	public function handle($request, Closure $next, $guard = null) {
		$user = null;

		//return $request->header();
		if ($request->hasHeader('api_token')) {
			$token = $request->header('api_token');
			//return $token;

			$user = User::where('api_token', $token)->first();
			// $user = User::first();
			if (is_null($user)) {
				return ['success' => false, 'error' => 'Invalid api token!'];
			}
			Auth::login($user); // log in the user
			$request->api_token = $token;
		} else {
			return ['success' => false, 'error' => 'API token not found!'];
		}

		$response = $next($request);

		return $this->format($response);
	}
	// the after middleware
	public function format($response) {
		// do things after filter stuff
        return $response;
	}

}