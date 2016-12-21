<?php

use Mockery as m;
use Ohio\Core\Base\Testing;

use Ohio\Core\UserRole\UserRole;
use Ohio\Core\UserRole\Http\Requests\CreateRequest;
use Ohio\Core\UserRole\Http\Requests\PaginateRequest;
use Ohio\Core\UserRole\Http\Requests\UpdateRequest;
use Ohio\Core\UserRole\Http\Controllers\ApiController;
use Ohio\Core\Base\Http\Exceptions\ApiNotFoundHttpException;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiControllerTest extends Testing\OhioTestCase
{

    use Testing\TestPaginateTrait;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\UserRole\Http\Controllers\ApiController::__construct
     * @covers \Ohio\Core\UserRole\Http\Controllers\ApiController::get
     * @covers \Ohio\Core\UserRole\Http\Controllers\ApiController::show
     * @covers \Ohio\Core\UserRole\Http\Controllers\ApiController::destroy
     * @covers \Ohio\Core\UserRole\Http\Controllers\ApiController::store
     * @covers \Ohio\Core\UserRole\Http\Controllers\ApiController::index
     */
    public function test()
    {
        $userRole1 = new UserRole();
        $userRole1->role_id = 1;

        $qbMock = $this->getPaginateQBMock(new PaginateRequest(), [$userRole1]);
        $qbMock->shouldReceive('with')->once();

        $userRoleRepository = m::mock(UserRole::class);
        $userRoleRepository->shouldReceive('find')->with(1)->andReturn($userRole1);
        $userRoleRepository->shouldReceive('find')->with(999)->andReturn(null);
        $userRoleRepository->shouldReceive('create')->andReturn($userRole1);
        $userRoleRepository->shouldReceive('query')->andReturn($qbMock);

        # construct
        $controller = new ApiController($userRoleRepository);
        $this->assertEquals($userRoleRepository, $controller->userRole);

        # get existing userRole
        $userRole = $controller->get(1);
        $this->assertEquals($userRole1->role_id, $userRole->role_id);

        # get userRole that doesn't exist
        try {
            $controller->get(999);
        } catch (\Exception $e) {
            $this->assertInstanceOf(ApiNotFoundHttpException::class, $e);
        }

        # show userRole
        $response = $controller->show(1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $data = $response->getData();
        $this->assertEquals($userRole1->role_id, $data->role_id);

        # destroy userRole
        $response = $controller->destroy(1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());

        # create userRole
        $response = $controller->store(new CreateRequest());
        $this->assertInstanceOf(JsonResponse::class, $response);

        # index
        $response = $controller->index(new Request());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($userRole1->role_id, $response->getData()->data[0]->role_id);

    }

}