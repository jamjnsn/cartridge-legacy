<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = RouteServiceProvider::HOME;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	public function login(Request $request)
	{
		$input = $request->only(['name', 'password']);

		$this->validate($request, [
			'name' => 'required',
			'password' => 'required',
		]);

		if (auth()->attempt(array('name' => $input['name'], 'password' => $input['password']))) {
			return redirect()->route('home');
		} else {
			return redirect()->route('login')
				->with('error', 'Invalid credentials provided.');
		}
	}
}
