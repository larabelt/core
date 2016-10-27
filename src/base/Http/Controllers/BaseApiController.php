<?php

namespace Ohio\Core\Base\Http\Controllers;

use Ohio\Core\Base\Http\Exception;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class BaseApiController extends Controller
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function abort($statusCode, $msg = '')
    {
        switch($statusCode) {
            case 404:
                throw new Exception\ApiNotFoundHttpException($msg);
                break;
            default:
                break;
        }
    }

}