<?php

use Belt\Core\Http\Controllers\BaseController;

class BaseControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Belt\Core\Http\Controllers\BaseController::env
     */
    public function test()
    {
        $controller = new BaseController();

        $this->assertEquals('local', $controller->env('APP_ENV'));

    }

}