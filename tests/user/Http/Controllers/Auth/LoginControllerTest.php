<?php

use Ohio\Core\Base\Testing;
use Ohio\Core\User\Http\Controllers\Auth\LoginController;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class LoginControllerTest extends Testing\OhioTestCase
{

    /**
     * @cover \Ohio\Core\User\Http\Controllers\LoginController::__construct
     * @cover \Ohio\Core\User\Http\Controllers\LoginController::showLoginForm
     * @cover \Ohio\Core\User\Http\Controllers\LoginController::logout
     */
    public function test()
    {

        # __construct
        $controller = new LoginController();

        # showLoginForm
        $view = $controller->showLoginForm();
        $this->assertInstanceOf(View::class, $view);

        # logout
        $request = new Request();
        $request->setSession($this->getTestSession());
        $response = $controller->logout($request);
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

}