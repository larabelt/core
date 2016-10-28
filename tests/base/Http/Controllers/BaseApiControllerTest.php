<?php

use Ohio\Core\Base\Http\Controllers\BaseApiController;
use Ohio\Core\Base\Http\Exception\ApiNotFoundHttpException;

class BaseApiControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Ohio\Core\Base\Http\Controllers\BaseApiController::abort()
     * @expectedException Ohio\Core\Base\Http\Exception\ApiNotFoundHttpException
     */
    public function testAbort404()
    {

        $controller = new BaseApiController();
        $controller->abort(404);
    }

    /**
     * @covers \Ohio\Core\Base\Http\Controllers\BaseApiController::abort()
     * @expectedException Ohio\Core\Base\Http\Exception\ApiException
     */
    public function testAbortNull()
    {

        $controller = new BaseApiController();
        $controller->abort(null);
    }

}