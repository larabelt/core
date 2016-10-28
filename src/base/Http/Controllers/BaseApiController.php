<?php

namespace Ohio\Core\Base\Http\Controllers;

use Ohio\Core\Base\Http\Exception;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BaseApiController extends Controller
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function abort($statusCode, $msg = '')
    {

        if ($statusCode == 404) throw new Exception\ApiNotFoundHttpException();

        throw new Exception\ApiException();
    }

}