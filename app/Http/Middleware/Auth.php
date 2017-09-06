<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class Auth
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth        	
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Is user is guest
        if ($this->auth->guest())
        {
            // Request for ajax is forbidden
            if ($request->ajax())
            {
                return response('Unauthorized.', 401);
            }
            else
            {
                // Redirect to login
                return redirect()->guest('auth/login');
            }
        }
        
        // Continue
        return $next($request);
    }
}
