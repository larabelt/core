<?php

namespace Ohio\Core\Base\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class BaseController extends Controller
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

}