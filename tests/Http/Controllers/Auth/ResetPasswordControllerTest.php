<?php

use Belt\Core\Testing;
use Belt\Core\Http\Controllers\Auth\ResetPasswordController;

use Illuminate\View\View;
use Illuminate\Http\Request;

class ResetPasswordControllerTest extends Testing\BeltTestCase
{

    /**
     * @cover \Belt\Core\Http\Controllers\Auth\ResetPasswordController::__construct
     * @cover \Belt\Core\Http\Controllers\Auth\ResetPasswordController::showResetForm
     */
    public function test()
    {
        # __construct
        $controller = new ResetPasswordController();

        # showResetForm
        $request = new Request();
        $view = $controller->showResetForm($request);
        $this->assertInstanceOf(View::class, $view);
    }

}