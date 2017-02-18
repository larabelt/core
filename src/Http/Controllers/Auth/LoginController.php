<?php

namespace Belt\Core\Http\Controllers\Auth;

use Belt\Core\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

/**
 * Class LoginController
 * @package Belt\Core\Http\Controllers\Auth
 */
class LoginController extends BaseController
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('belt-core::auth.login');
    }

    /**
     * @return string
     */
    public function redirectTo()
    {
        $user = $this->guard()->user();

        if ($user->hasRole('ADMIN')) {
            return '/admin';
        }

        return $this->redirectTo;
    }

}
