<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Class APIV1
 * @package App\Http\Middleware
 */
class APIV1
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = null;

        $headers = getallheaders();
        if(! empty($headers['api_token']))
        {
            $token = $headers['api_token'];
        

            $user = \App\Models\Access\User\User::where('api_token', bcrypt($token))->first();
            $user = \App\Models\Access\User\User::first();
            if (is_null($user)) {
                return ['success'=>false, 'error'=>'Invalid api token!'];
            }
            Auth::login($user); // log in the user
        }
        else {
            return ['success'=>false, 'error'=>'API token not found!'];
        }

        $response = $next($request);

        return $this->format($response);
    }
    // the after middleware
    public function format($response){
        return $response;
    }

}