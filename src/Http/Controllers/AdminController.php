<?php namespace Ohio\Base\Http\Controllers;

//use Auth, Cookie, Input, Redirect, Response, Session, Validator, View;
//use Gregwar\Captcha\CaptchaBuilder;
//use SOM\Core\Model\Token;
//use SOM\Core\Helper\ConfigHelper;
//use SOM\User\Model\User;

use Auth;
use Illuminate\Http\Request;

class AdminController extends BaseController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('web');
    }

    /**
     * Display dashboard
     *
     * @return Response
     */
    public function getIndex()
    {
        return view('base::admin.index');
    }

}