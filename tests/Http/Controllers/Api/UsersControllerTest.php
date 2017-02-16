<?php

use Mockery as m;
use Belt\Core\Testing;

use Belt\Core\User;
use Belt\Core\Http\Requests\StoreUser;
use Belt\Core\Http\Requests\PaginateUsers;
use Belt\Core\Http\Requests\UpdateUser;
use Belt\Core\Http\Controllers\Api\UsersController;
use Belt\Core\Http\Exceptions\ApiNotFoundHttpException;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersControllerTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Controllers\Api\UsersController::__construct
     * @covers \Belt\Core\Http\Controllers\Api\UsersController::get
     * @covers \Belt\Core\Http\Controllers\Api\UsersController::show
     * @covers \Belt\Core\Http\Controllers\Api\UsersController::destroy
     * @covers \Belt\Core\Http\Controllers\Api\UsersController::update
     * @covers \Belt\Core\Http\Controllers\Api\UsersController::store
     * @covers \Belt\Core\Http\Controllers\Api\UsersController::index
     */
    public function test()
    {

        $this->actAsSuper();

        $user1 = factory(User::class)->make();

        $qbMock = $this->getPaginateQBMock(new PaginateUsers(), [$user1]);

        $userRepository = m::mock(User::class);
        $userRepository->shouldReceive('find')->with(1)->andReturn($user1);
        $userRepository->shouldReceive('find')->with(999)->andReturn(null);
        $userRepository->shouldReceive('create')->andReturn($user1);
        $userRepository->shouldReceive('query')->andReturn($qbMock);

        # construct
        $controller = new UsersController($userRepository);
        $this->assertEquals($userRepository, $controller->users);

        # get existing user
        $user = $controller->get(1);
        $this->assertEquals($user1->name, $user->name);

        # get user that doesn't exist
        try {
            $controller->get(999);
        } catch (\Exception $e) {
            $this->assertInstanceOf(ApiNotFoundHttpException::class, $e);
        }

        # show user
        $response = $controller->show(1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $data = $response->getData();
        $this->assertEquals($user1->email, $data->email);

        # destroy user
        $response = $controller->destroy(1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());

        # update user
        $response = $controller->update(new UpdateUser(), 1);
        $this->assertInstanceOf(JsonResponse::class, $response);

        # create user
        $response = $controller->store(new StoreUser(['email' => 'test@test.com']));
        $this->assertInstanceOf(JsonResponse::class, $response);

        # index
        //$response = $controller->index(new Request());
        $response = $controller->index(new PaginateUsers());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($user1->email, $response->getData()->data[0]->email);

    }

}