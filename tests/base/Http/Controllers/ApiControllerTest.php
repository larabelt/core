<?php

use Ohio\Core\Base\Http\Controllers\ApiController;
use Ohio\Core\Base\Http\Exceptions;
use Ohio\Core\Base\Testing\CommonMocks;
use Ohio\Core\Base\Http\Requests\PaginateRequest;
use Ohio\Core\Base\Pagination\BaseLengthAwarePaginator;
use Ohio\Core\User\User;
use Ohio\Core\User\Http\Requests\PaginateUsers;

class ApiControllerTest extends \PHPUnit_Framework_TestCase
{
    use CommonMocks;

    /**
     * @covers \Ohio\Core\Base\Http\Controllers\ApiController::abort
     * @covers \Ohio\Core\Base\Http\Controllers\ApiController::paginator
     * @covers \Ohio\Core\Base\Http\Controllers\ApiController::getPaginateRequest
     * @covers \Ohio\Core\Base\Http\Controllers\ApiController::set
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