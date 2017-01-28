<?php

use Mockery as m;
use Ohio\Core\Testing;
use Ohio\Core\Http\Exceptions\ApiException;
use Ohio\Core\User;
use Ohio\Core\Role;
use Ohio\Core\Http\Requests\AttachRole;
use Ohio\Core\Http\Requests\PaginateUserRoles;
use Ohio\Core\Http\Controllers\Api\UserRolesController;
use Illuminate\Http\JsonResponse;

class UserRolesControllerTest extends Testing\OhioTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\Http\Controllers\Api\RolesController::__construct
     * @covers \Ohio\Core\Http\Controllers\Api\RolesController::user
     * @covers \Ohio\Core\Http\Controllers\Api\RolesController::role
     * @covers \Ohio\Core\Http\Controllers\Api\RolesController::show
     * @covers \Ohio\Core\Http\Controllers\Api\RolesController::destroy
     * @covers \Ohio\Core\Http\Controllers\Api\RolesController::store
     * @covers \Ohio\Core\Http\Controllers\Api\RolesController::index
     */
    public function test()
    {
        User::unguard();
        Role::unguard();

        $role1 = factory(Role::class)->make();
        $role1->id = 101;
        $role2 = factory(Role::class)->make();
        $role2->id = 102;

        $user1 = factory(User::class)->make();
        $user1->id = 1;
        $user1->roles->add($role1);

        $userRepository = m::mock(User::class);
        $userRepository->shouldReceive('find')->with(1)->andReturn($user1);
        $userRepository->shouldReceive('find')->with(999)->andReturn(null);

        $roleRepository = m::mock(Role::class);
        $roleRepository->shouldReceive('find')->with(101)->andReturn($role1);
        $roleRepository->shouldReceive('find')->with(102)->andReturn($role2);
        $roleRepository->shouldReceive('find')->with(999)->andReturn(null);
        $roleRepository->shouldReceive('create')->andReturn($role1);
        $roleRepository->shouldReceive('query')->andReturn($this->getQBMock());

        # construct
        $controller = new UserRolesController($userRepository, $roleRepository);
        $this->assertEquals($userRepository, $controller->users);
        $this->assertEquals($roleRepository, $controller->roles);

        # user
        $user = $controller->user(1);
        $this->assertEquals($user1->name, $user->name);
        try {
            $controller->user(999);
            $this->exceptionNotThrown();
        } catch (ApiException $e) {
            $this->assertEquals(404, $e->getStatusCode());
        }

        # role
        $role = $controller->role(101);
        $this->assertEquals($role1->email, $role->email);
        $role = $controller->role(101, $user);
        $this->assertEquals($role1->email, $role->email);
        try {
            $controller->role(999);
            $this->exceptionNotThrown();
        } catch (ApiException $e) {
            $this->assertEquals(404, $e->getStatusCode());
        }
        try {
            $controller->role(102, $user1);
            $this->exceptionNotThrown();
        } catch (ApiException $e) {
            $this->assertEquals(400, $e->getStatusCode());
        }

        # show
        $response = $controller->show(1, 101);
        $this->assertEquals(200, $response->getStatusCode());

        # attach role
        $response = $controller->store(new AttachRole(['id' => 102]), 1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        try {
            // role already attached
            $controller->store(new AttachRole(['id' => 101]), 1);
            $this->exceptionNotThrown();
        } catch (ApiException $e) {
            $this->assertEquals(422, $e->getStatusCode());
        }

        # detach role
        $response = $controller->destroy(1, 101);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
        try {
            // role already not attached
            $controller->destroy(1, 102);
            $this->exceptionNotThrown();
        } catch (ApiException $e) {
            $this->assertEquals(422, $e->getStatusCode());
        }

        # index
        $paginatorMock = $this->getPaginatorMock();
        $paginatorMock->shouldReceive('toArray')->andReturn([]);
        $controller = m::mock(UserRolesController::class . '[paginator]', [$userRepository, $roleRepository]);
        $controller->shouldReceive('paginator')->andReturn($paginatorMock);
        $response = $controller->index(new PaginateUserRoles(), 1);
        $this->assertEquals(200, $response->getStatusCode());
    }

}