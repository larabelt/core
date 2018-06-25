<?php

use Belt\Core\Testing;
use Belt\Core\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ResetPasswordControllerTest extends Testing\BeltTestCase
{

    /**
     * @cover \Belt\Core\Http\Controllers\Auth\ResetPasswordController::__construct
     * @cover \Belt\Core\Http\Controllers\Auth\ResetPasswordController::showResetForm
     * @cover \Belt\Core\Http\Controllers\Auth\ResetPasswordController::redirectTo
     */
    public function test()
    {
        # __construct
        $controller = new ResetPasswordController();

        # showResetForm
        $request = new Request();
        $view = $controller->showResetForm($request);
        $this->assertInstanceOf(View::class, $view);

        # redirectTo (non-admin)
        $this->assertEquals('/home', $controller->redirectTo());

        # redirectTO (admin)
        $user = factory(\Belt\Core\User::class)->make(['is_super' => true]);
        Auth::shouldReceive('user')->andReturn($user);
        $this->assertEquals('/admin', $controller->redirectTo());

    }

}