<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    /**
     * Method that redirects the user to Dashboard or Login depending on whether it is logged in or not
     * @return index or login
     */
    public function getLogin()
    {
        // To determine if the user is already logged
        if (Auth::check())
        {
            // The user is logged: redirect to Dashboard
            return Redirect::route('index');
        }
        else
        {
            // The user isn't logged: redirect to Login
            return view('auth.login');
        }
    }

    /**
     * Method that verifies the user credentials
     * @param Request $request
     * @return Redirect to index or show errors
     */
    public function postLogin(Request $request)
    {
        // Get Login input
        $login = $request->input('login');

        // Check login field, email or username
        $login_type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Merge login field into the request with either email or username as key
        $request->merge([$login_type => $login]);

        // Validate and set credentials
        if ($login_type == 'email')
        {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            $credentials = $request->only('email', 'password');
        }
        else
        {
            $this->validate($request, [
                'username' => 'required',
                'password' => 'required',
            ]);
            $credentials = $request->only('username', 'password');
        }
        // If credentials are verified

        if (Auth::attempt($credentials, $request->has('remember')))
        {
            //Check if the user is already logged in
            if (Auth::check())
            {
                // Check if user account is enabled
                if (Auth::user()->enable === 1)
                {
                    // Update the last_login of user
                    Auth::user()->last_login = date('Y-m-d H:i:s');
                    Auth::user()->save();

                    // Redirect to index
                    return Redirect::route('index');
                }
                else
                {
                    // Log out the user
                    Auth::logout();
                    return Redirect::route('login')->with('danger', __('auth.disabled'))->withInput();
                }
            }
        }
        else
        {
            return Redirect::route('login')->with('danger', __('auth.failed'))->withInput();
        }
    }

    /**
     * Method that log out the user
     * @return type
     */
    public function getLogout()
    {
        // Save Log for the logout
        $user = Auth::user();
        Log::info('User Logged Out. ', [$user]);

        // Logout
        Auth::logout();

        // Clean Session
        Session::flush();

        // Redirect
        return Redirect::route('login');
    }

}
