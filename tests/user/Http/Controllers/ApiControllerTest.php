<?php

use Mockery as m;
use Ohio\Core\Base\Testing;

use Ohio\Core\User\User;
use Ohio\Core\User\Http\Requests\CreateRequest;
use Ohio\Core\User\Http\Requests\PaginateRequest;
use Ohio\Core\User\Http\Requests\UpdateRequest;
use Ohio\Core\User\Http\Controllers\ApiController;
use Ohio\Core\Base\Http\Exception\ApiNotFoundHttpException;

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
     * @covers \Ohio\Core\User\Http\Controllers\ApiController::__construct
     * @covers \Ohio\Core\User\Http\Controllers\ApiController::get
     * @covers \Ohio\Core\User\Http\Controllers\ApiController::show
     * @covers \Ohio\Core\User\Http\Controllers\ApiController::destroy
     * @covers \Ohio\Core\User\Http\Controllers\ApiController::update
     * @covers \Ohio\Core\User\Http\Controllers\ApiController::store
     * @covers \Ohio\Core\User\Http\Controllers\ApiController::index
     */
    public function test()
    {

        $user1 = factory(User::class)->make();

        $qbMock = $this->getPaginateQBMock(new PaginateRequest(), [$user1]);

        $userRepository = m::mock(User::class);
        $userRepository->shouldReceive('find')->with(1)->andReturn($user1);
        $userRepository->shouldReceive('find')->with(999)->andReturn(null);
        $userRepository->shouldReceive('create')->andReturn($user1);
        $userRepository->shouldReceive('query')->andReturn($qbMock);

        # construct
        $controller = new ApiController($userRepository);
        $this->assertEquals($userRepository, $controller->user);

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
        $response = $controller->update(new UpdateRequest(), 1);
        $this->assertInstanceOf(JsonResponse::class, $response);

        # create user
        $response = $controller->store(new CreateRequest());
        $this->assertInstanceOf(JsonResponse::class, $response);

        # index
        $response = $controller->index(new Request());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($user1->email, $response->getData()->data[0]->email);

    }

}