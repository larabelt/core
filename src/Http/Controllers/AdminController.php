<?php namespace Ohio\Base\Http\Controllers;

//use Auth, Cookie, Input, Redirect, Response, Session, Validator, View;
//use Gregwar\Captcha\CaptchaBuilder;
//use SOM\Core\Model\Token;
//use SOM\Core\Helper\ConfigHelper;
//use SOM\User\Model\User;

use Auth, Gate;
use Illuminate\Http\Request;

class AdminController extends BaseController
{

    /**
     * Display dashboard
     *
     * @return Response
     */
    public function getIndex()
    {

        if (Gate::denies('admin-index')) {
            //abort(403);
            //s(403);
        }

        return view('base::admin.index');
    }

}