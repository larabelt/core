<?php

use Mockery as m;
use Ohio\Core\Testing;

use Ohio\Core\Team;
use Ohio\Core\Http\Requests\StoreTeam;
use Ohio\Core\Http\Requests\PaginateTeams;
use Ohio\Core\Http\Requests\UpdateTeam;
use Ohio\Core\Http\Controllers\Api\TeamsController;
use Ohio\Core\Http\Exceptions\ApiNotFoundHttpException;

use Illuminate\Http\JsonResponse;

class TeamsControllerTest extends Testing\OhioTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\Http\Controllers\Api\TeamsController::__construct
     * @covers \Ohio\Core\Http\Controllers\Api\TeamsController::get
     * @covers \Ohio\Core\Http\Controllers\Api\TeamsController::show
     * @covers \Ohio\Core\Http\Controllers\Api\TeamsController::destroy
     * @covers \Ohio\Core\Http\Controllers\Api\TeamsController::update
     * @covers \Ohio\Core\Http\Controllers\Api\TeamsController::store
     * @covers \Ohio\Core\Http\Controllers\Api\TeamsController::index
     */
    public function test()
    {
        $this->actAsSuper();

        $team1 = factory(Team::class)->make();

        $qbMock = $this->getPaginateQBMock(new PaginateTeams(), [$team1]);

        $teamRepository = m::mock(Team::class);
        $teamRepository->shouldReceive('find')->with(1)->andReturn($team1);
        $teamRepository->shouldReceive('find')->with(999)->andReturn(null);
        $teamRepository->shouldReceive('create')->andReturn($team1);
        $teamRepository->shouldReceive('query')->andReturn($qbMock);

        # construct
        $controller = new TeamsController($teamRepository);
        $this->assertEquals($teamRepository, $controller->teams);

        # get existing team
        $team = $controller->get(1);
        $this->assertEquals($team1->name, $team->name);

        # get team that doesn't exist
        try {
            $controller->get(999);
        } catch (\Exception $e) {
            $this->assertInstanceOf(ApiNotFoundHttpException::class, $e);
        }

        # show team
        $response = $controller->show(1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $data = $response->getData();
        $this->assertEquals($team1->name, $data->name);

        # destroy team
        $response = $controller->destroy(1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());

        # update team
        $response = $controller->update(new UpdateTeam(), 1);
        $this->assertInstanceOf(JsonResponse::class, $response);

        # create team
        $response = $controller->store(new StoreTeam(['name' => 'test']));
        $this->assertInstanceOf(JsonResponse::class, $response);

        # index
        $response = $controller->index(new PaginateTeams());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($team1->name, $response->getData()->data[0]->name);

    }

}