<?php

use Mockery as m;
use Ohio\Core\Base\Testing;

use Ohio\Core\Role\Role;
use Ohio\Core\Role\Http\Requests\CreateRequest;
use Ohio\Core\Role\Http\Requests\PaginateRequest;
use Ohio\Core\Role\Http\Requests\UpdateRequest;
use Ohio\Core\Role\Http\Controllers\ApiController;
use Ohio\Core\Base\Http\Exception\ApiNotFoundHttpException;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class ApiControllerTest extends Testing\OhioTestCase
{

    use Testing\TestPaginateTrait;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\Role\Http\Controllers\ApiController::__construct
     * @covers \Ohio\Core\Role\Http\Controllers\ApiController::get
     * @covers \Ohio\Core\Role\Http\Controllers\ApiController::show
     * @covers \Ohio\Core\Role\Http\Controllers\ApiController::destroy
     * @covers \Ohio\Core\Role\Http\Controllers\ApiController::update
     * @covers \Ohio\Core\Role\Http\Controllers\ApiController::store
     * @covers \Ohio\Core\Role\Http\Controllers\ApiController::index
     */
    public function test1()
    {

        $role1 = factory(Role::class)->make();

        $qbMock = $this->getPaginateQBMock(new PaginateRequest(), [$role1]);

        $roleRepository = m::mock(Role::class);
        $roleRepository->shouldReceive('find')->with(1)->andReturn($role1);
        $roleRepository->shouldReceive('find')->with(999)->andReturn(null);
        $roleRepository->shouldReceive('create')->andReturn($role1);
        $roleRepository->shouldReceive('query')->andReturn($qbMock);

        # construct
        $controller = new ApiController($roleRepository);
        $this->assertEquals($roleRepository, $controller->role);

        # get existing role
        $role = $controller->get(1);
        $this->assertEquals($role1->name, $role->name);

        # get role that doesn't exist
        try {
            $controller->get(999);
        } catch (\Exception $e) {
            $this->assertInstanceOf(ApiNotFoundHttpException::class, $e);
        }

        # show role
        $response = $controller->show(1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $data = $response->getData();
        $this->assertEquals($role1->name, $data->name);

        # destroy role
        $response = $controller->destroy(1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());

        # update role
        $response = $controller->update(new UpdateRequest(), 1);
        $this->assertInstanceOf(JsonResponse::class, $response);

        # create role
        $response = $controller->store(new CreateRequest());
        $this->assertInstanceOf(JsonResponse::class, $response);

        # index
        $response = $controller->index(new Request());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($role1->name, $response->getData()->data[0]->name);

    }

}