<?php

use Belt\Core\Testing;
use Belt\Core\Http\Controllers\Auth\ForgotPasswordController;

use Illuminate\View\View;

class ForgotPasswordControllerTest extends Testing\BeltTestCase
{

    /**
     * @cover \Belt\Core\Http\Controllers\Auth\ForgotPasswordController::__construct
     * @cover \Belt\Core\Http\Controllers\Auth\ForgotPasswordController::showLinkRequestForm
     */
    public function test()
    {
        # __construct
        $controller = new ForgotPasswordController();

        # showLinkRequestForm
        $view = $controller->showLinkRequestForm();
        $this->assertInstanceOf(View::class, $view);
    }

}