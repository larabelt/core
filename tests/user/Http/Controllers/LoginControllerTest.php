<?php

use Ohio\Core\Base\Testing;
use Ohio\Core\User\Http\Controllers\LoginController;

use Illuminate\View\View;

class LoginControllerTest extends Testing\OhioTestCase
{

    /**
     * @cover \Ohio\Core\User\Http\Controllers\LoginController::__construct
     * @cover \Ohio\Core\User\Http\Controllers\LoginController::showLoginForm
     */
    public function test()
    {

        $controller = new LoginController();

        $view = $controller->showLoginForm();
        $this->assertInstanceOf(View::class, $view);
    }

}