<?php

use Ohio\Core\Base\Http\Controllers\BaseApiController;
use Ohio\Core\Base\Http\Exceptions;
use Ohio\Core\Base\Testing\CommonMocks;
use Ohio\Core\Base\Http\Requests\BasePaginateRequest;
use Ohio\Core\Base\Pagination\BaseLengthAwarePaginator;
use Ohio\Core\User\User;
use Ohio\Core\User\Http\Requests\PaginateRequest;

class BaseApiControllerTest extends \PHPUnit_Framework_TestCase
{
    use CommonMocks;

    /**
     * @covers \Ohio\Core\Base\Http\Controllers\BaseApiController::abort
     * @covers \Ohio\Core\Base\Http\Controllers\BaseApiController::paginator
     * @covers \Ohio\Core\Base\Http\Controllers\BaseApiController::getPaginateRequest
     * @covers \Ohio\Core\Base\Http\Controllers\BaseApiController::set
     */
    public function test()
    {
        $controller = new BaseApiController();

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
        $paginator = $controller->paginator($qbMock, new BasePaginateRequest());
        $this->assertInstanceOf(BaseLengthAwarePaginator::class, $paginator);

        # getPaginateRequest
        $request = $controller->getPaginateRequest(BasePaginateRequest::class, []);
        $this->assertInstanceOf(BasePaginateRequest::class, $request);
        $request = $controller->getPaginateRequest(BasePaginateRequest::class, []);
        $this->assertInstanceOf(BasePaginateRequest::class, $request);
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