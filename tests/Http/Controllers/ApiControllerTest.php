<?php

use Mockery as m;
use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Http\Exceptions;
use Belt\Core\Testing\CommonMocks;
use Belt\Core\Http\Requests\PaginateRequest;
use Belt\Core\Pagination\DefaultLengthAwarePaginator;
use Belt\Core\User;

class ApiControllerTest extends \PHPUnit_Framework_TestCase
{
    use CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Controllers\ApiController::abort
     * @covers \Belt\Core\Http\Controllers\ApiController::paginator
     * @covers \Belt\Core\Http\Controllers\ApiController::getPaginateRequest
     * @covers \Belt\Core\Http\Controllers\ApiController::set
     * @covers \Belt\Core\Http\Controllers\ApiController::setIfNotEmpty
     */
    public function test()
    {
        $controller = new ApiController();

        # abort 404
        try {
            $controller->abort(404);
        } catch (\Exception $e) {
            $this->assertInstanceOf(Exceptions\ApiNotFoundHttpException::class, $e);
        }

        # abort null
        try {
            $controller->abort(null);
        } catch (\Exception $e) {
            $this->assertInstanceOf(Exceptions\ApiException::class, $e);
        }

        # paginator
        $qbMock = $this->getPaginateQBMock();
        $paginator = $controller->paginator($qbMock, new PaginateRequest());
        $this->assertInstanceOf(DefaultLengthAwarePaginator::class, $paginator);

        # getPaginateRequest
        $request = $controller->getPaginateRequest(PaginateRequest::class, []);
        $this->assertInstanceOf(PaginateRequest::class, $request);
        $request = $controller->getPaginateRequest(PaginateRequest::class, []);
        $this->assertInstanceOf(PaginateRequest::class, $request);
        try {
            $controller->getPaginateRequest('something stupid');
        } catch (\Exception $e) {
            $somethingStupidHappened = true;
        }
        $this->assertTrue(isset($somethingStupidHappened));

        # set
        $user = new User();
        $controller->set($user, [
            'first_name' => 'clark',
            'last_name' => 'kent',
            'something_else' => 'does not matter',
        ], [
            'first_name',
            'last_name',
        ]);
        $this->assertEquals('CLARK', $user->first_name);
        $this->assertEquals('KENT', $user->last_name);

        # setIfNotEmpty
        $user = new User();
        $this->assertNull($user->password1);
        $this->assertNull($user->password2);
        $controller->setIfNotEmpty($user, [
            'password1' => '',
            'password2' => 'not-empty',
        ], [
            'password1',
            'password2',
        ]);
        $this->assertNull($user->password1);
        $this->assertNotNull($user->password2);
    }

}