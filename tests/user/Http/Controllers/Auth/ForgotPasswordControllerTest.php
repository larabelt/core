<?php

use Ohio\Core\Base\Testing;
use Ohio\Core\User\Http\Controllers\Auth\ForgotPasswordController;

use Illuminate\View\View;

class ForgotPasswordControllerTest extends Testing\OhioTestCase
{

    /**
     * @cover \Ohio\Core\User\Http\Controllers\ForgotPasswordController::__construct
     * @cover \Ohio\Core\User\Http\Controllers\ForgotPasswordController::showLinkRequestForm
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