<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Role;
use Belt\Core\Http\Requests\StoreRole;
use Belt\Core\Http\Requests\PaginateRoles;
use Belt\Core\Http\Requests\UpdateRole;
use Belt\Core\Http\Controllers\Api\RolesController;
use Belt\Core\Http\Exceptions\ApiNotFoundHttpException;

use Illuminate\Http\JsonResponse;

class RolesControllerTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Controllers\Api\RolesController::__construct
     * @covers \Belt\Core\Http\Controllers\Api\RolesController::get
     * @covers \Belt\Core\Http\Controllers\Api\RolesController::show
     * @covers \Belt\Core\Http\Controllers\Api\RolesController::destroy
     * @covers \Belt\Core\Http\Controllers\Api\RolesController::update
     * @covers \Belt\Core\Http\Controllers\Api\RolesController::store
     * @covers \Belt\Core\Http\Controllers\Api\RolesController::index
     */
    public function test()
    {
        $this->actAsSuper();

        $role1 = factory(Role::class)->make();

        $qbMock = $this->getPaginateQBMock(new PaginateRoles(), [$role1]);

        $roleRepository = m::mock(Role::class);
        $roleRepository->shouldReceive('find')->with(1)->andReturn($role1);
        $roleRepository->shouldReceive('find')->with(999)->andReturn(null);
        $roleRepository->shouldReceive('create')->andReturn($role1);
        $roleRepository->shouldReceive('query')->andReturn($qbMock);

        # construct
        $controller = new RolesController($roleRepository);
        $this->assertEquals($roleRepository, $controller->roles);

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
        $response = $controller->update(new UpdateRole(), 1);
        $this->assertInstanceOf(JsonResponse::class, $response);

        # create role
        $response = $controller->store(new StoreRole(['name' => 'test']));
        $this->assertInstanceOf(JsonResponse::class, $response);

        # index
        $response = $controller->index(new PaginateRoles());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($role1->name, $response->getData()->data[0]->name);

    }

}