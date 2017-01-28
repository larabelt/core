<?php

use Ohio\Core\Testing;
use Ohio\Core\Http\Controllers\Auth\ResetPasswordController;

use Illuminate\View\View;
use Illuminate\Http\Request;

class ResetPasswordControllerTest extends Testing\OhioTestCase
{

    /**
     * @cover \Ohio\Core\Http\Controllers\ResetPasswordController::__construct
     * @cover \Ohio\Core\Http\Controllers\ResetPasswordController::showResetForm
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