<?php

use Mockery as m;
use Ohio\Core\Base\Testing;

use Ohio\Core\TeamUser\TeamUser;
use Ohio\Core\TeamUser\Http\Requests\CreateRequest;
use Ohio\Core\TeamUser\Http\Requests\PaginateRequest;
use Ohio\Core\TeamUser\Http\Requests\UpdateRequest;
use Ohio\Core\TeamUser\Http\Controllers\Api\TeamUsersController;
use Ohio\Core\Base\Http\Exceptions\ApiNotFoundHttpException;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamUsersControllerTest extends Testing\OhioTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\TeamUser\Http\Controllers\Api\TeamUsersController::__construct
     * @covers \Ohio\Core\TeamUser\Http\Controllers\Api\TeamUsersController::get
     * @covers \Ohio\Core\TeamUser\Http\Controllers\Api\TeamUsersController::show
     * @covers \Ohio\Core\TeamUser\Http\Controllers\Api\TeamUsersController::destroy
     * @covers \Ohio\Core\TeamUser\Http\Controllers\Api\TeamUsersController::store
     * @covers \Ohio\Core\TeamUser\Http\Controllers\Api\TeamUsersController::index
     */
    public function test()
    {
        $teamUser1 = new TeamUser();
        $teamUser1->id = 1;
        $teamUser1->team_id = 1;
        $teamUser1->user_id = 1;

        $qbMock = $this->getPaginateQBMock(new PaginateRequest(), [$teamUser1]);
        $qbMock->shouldReceive('join')->once();

        $teamUserRepository = m::mock(TeamUser::class);
        $teamUserRepository->shouldReceive('find')->with(1)->andReturn($teamUser1);
        $teamUserRepository->shouldReceive('find')->with(999)->andReturn(null);
        $teamUserRepository->shouldReceive('create')->andReturn($teamUser1);
        $teamUserRepository->shouldReceive('query')->andReturn($qbMock);

        # construct
        $controller = new TeamUsersController($teamUserRepository);
        $this->assertEquals($teamUserRepository, $controller->teamUser);

        # get existing teamUser
        $teamUser = $controller->get(1);
        $this->assertEquals($teamUser1->user_id, $teamUser->user_id);

        # get teamUser that doesn't exist
        try {
            $controller->get(999);
        } catch (\Exception $e) {
            $this->assertInstanceOf(ApiNotFoundHttpException::class, $e);
        }

        # show teamUser
        $response = $controller->show(1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $data = $response->getData();
        $this->assertEquals($teamUser1->user_id, $data->user_id);

        # destroy teamUser
        $response = $controller->destroy(1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());

        # create teamUser
        $response = $controller->store(new CreateRequest());
        $this->assertInstanceOf(JsonResponse::class, $response);

        # index
        $response = $controller->index(new PaginateRequest());
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

}