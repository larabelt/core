<?php

use Ohio\Core\Testing;
use Ohio\Core\Http\Controllers\Auth\ForgotPasswordController;

use Illuminate\View\View;

class ForgotPasswordControllerTest extends Testing\OhioTestCase
{

    /**
     * @cover \Ohio\Core\Http\Controllers\ForgotPasswordController::__construct
     * @cover \Ohio\Core\Http\Controllers\ForgotPasswordController::showLinkRequestForm
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