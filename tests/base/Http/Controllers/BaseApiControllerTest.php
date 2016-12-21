<?php

use Ohio\Core\Base\Http\Controllers\BaseApiController;
use Ohio\Core\Base\Http\Exceptions;
use Ohio\Core\Base\Testing\TestPaginateTrait;
use Ohio\Core\Base\Http\Requests\BasePaginateRequest;
use Ohio\Core\Base\Pagination\BaseLengthAwarePaginator;
use Ohio\Core\User\Http\Requests\PaginateRequest;

class BaseApiControllerTest extends \PHPUnit_Framework_TestCase
{
    use TestPaginateTrait;

    /**
     * @covers \Ohio\Core\Base\Http\Controllers\BaseApiController::abort
     * @covers \Ohio\Core\Base\Http\Controllers\BaseApiController::getPaginator
     * @covers \Ohio\Core\Base\Http\Controllers\BaseApiController::getPaginateRequest
     */
    public function test()
    {
        $controller = new BaseApiController();

        # abort 404
        try {
            $controller->abort(404);
        } catch (\Exception $e) {
            $this->assertInstanceOf(Exception\ApiNotFoundHttpException::class, $e);
        }

        # abort null
        try {
            $controller->abort(null);
        } catch (\Exception $e) {
            $this->assertInstanceOf(Exception\ApiException::class, $e);
        }

        # getPaginator
        $qbMock = $this->getPaginateQBMock();
        $paginator = $controller->getPaginator($qbMock, new BasePaginateRequest());
        $this->assertInstanceOf(BaseLengthAwarePaginator::class, $paginator);

        # getPaginateRequest
        $request = $controller->getPaginateRequest(BasePaginateRequest::class, []);
        $this->assertInstanceOf(BasePaginateRequest::class, $request);
        $request = $controller->getPaginateRequest(PaginateRequest::class, []);
        $this->assertInstanceOf(BasePaginateRequest::class, $request);
        try {
            $controller->getPaginateRequest('something stupid');
        } catch (\Exception $e) {
            $somethingStupidHappened = true;
        }
        $this->assertTrue(isset($somethingStupidHappened));

    }

}