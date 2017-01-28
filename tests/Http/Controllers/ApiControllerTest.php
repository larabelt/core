<?php

use Ohio\Core\Http\Controllers\ApiController;
use Ohio\Core\Http\Exceptions;
use Ohio\Core\Testing\CommonMocks;
use Ohio\Core\Http\Requests\PaginateRequest;
use Ohio\Core\Pagination\BaseLengthAwarePaginator;
use Ohio\Core\User;
use Ohio\Core\Http\Requests\PaginateUsers;

class ApiControllerTest extends \PHPUnit_Framework_TestCase
{
    use CommonMocks;

    /**
     * @covers \Ohio\Core\Http\Controllers\ApiController::abort
     * @covers \Ohio\Core\Http\Controllers\ApiController::paginator
     * @covers \Ohio\Core\Http\Controllers\ApiController::getPaginateRequest
     * @covers \Ohio\Core\Http\Controllers\ApiController::set
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
        $this->assertInstanceOf(BaseLengthAwarePaginator::class, $paginator);

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

        #set
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

    }

}