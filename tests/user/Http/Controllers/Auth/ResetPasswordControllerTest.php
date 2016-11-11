<?php

use Ohio\Core\Base\Testing;
use Ohio\Core\User\Http\Controllers\Auth\ResetPasswordController;

use Illuminate\View\View;
use Illuminate\Http\Request;

class ResetPasswordControllerTest extends Testing\OhioTestCase
{

    /**
     * @cover \Ohio\Core\User\Http\Controllers\ResetPasswordController::__construct
     * @cover \Ohio\Core\User\Http\Controllers\ResetPasswordController::showResetForm
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