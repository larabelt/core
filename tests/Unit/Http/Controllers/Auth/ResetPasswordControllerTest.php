<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Controllers\Auth\ResetPasswordController;
use Belt\Core\Tests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ResetPasswordControllerTest extends Tests\BeltTestCase
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