<?php

use Mockery as m;
use Ohio\Core\Base\Testing;
use Ohio\Core\User\Http\Controllers\Auth\LoginController;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Auth\StatefulGuard;

class LoginControllerTest extends Testing\OhioTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @cover \Ohio\Core\User\Http\Controllers\LoginController::__construct
     * @cover \Ohio\Core\User\Http\Controllers\LoginController::showLoginForm
     * @cover \Ohio\Core\User\Http\Controllers\LoginController::logout
     * @cover \Ohio\Core\User\Http\Controllers\LoginController::redirectTo
     */
    public function test()
    {

        # __construct
        $controller = new LoginController();

        # showLoginForm
        $view = $controller->showLoginForm();
        $this->assertInstanceOf(View::class, $view);

        # redirect to
        $controller = new LoginControllerStub1();
        $this->assertEquals('/home', $controller->redirectTo());
        $controller = new LoginControllerStub2();
        $this->assertEquals('/admin', $controller->redirectTo());
    }

}

class LoginControllerStub1 extends LoginController
{
    public function guard()
    {
        $user1 = m::mock(\Ohio\Core\User\User::class);
        $user1->shouldReceive('hasRole')->once()->andReturn(false);

        $guard = m::mock(StatefulGuard::class);
        $guard->shouldReceive('user')->once()->andReturn($user1);

        return $guard;
    }
}

class LoginControllerStub2 extends LoginController
{
    public function guard()
    {
        $user2 = m::mock(\Ohio\Core\User\User::class);
        $user2->shouldReceive('hasRole')->once()->andReturn(true);

        $guard = m::mock(StatefulGuard::class);
        $guard->shouldReceive('user')->once()->andReturn($user2);

        return $guard;
    }
}