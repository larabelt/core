<?php

namespace Ohio\Core\User\Http\Controllers;

use Validator;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Ohio\Core\Base\Http\Controllers\BaseController;

class LoginController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin-user';
    protected $redirectAfterLogout = '/login';
    protected $loginView = 'ohio-core::user.front.auth.login';

    /**
     * Create a new controller instance.
     *
     * @return void
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
        return view('ohio-core::auth.login');
    }


}
