<?php

use Mockery as m;
use Ohio\Core\Base\Testing;

use Ohio\Core\Team\Team;
use Ohio\Core\Team\Http\Requests\CreateRequest;
use Ohio\Core\Team\Http\Requests\PaginateRequest;
use Ohio\Core\Team\Http\Requests\UpdateRequest;
use Ohio\Core\Team\Http\Controllers\ApiController;
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
     * @covers \Ohio\Core\Team\Http\Controllers\ApiController::__construct
     * @covers \Ohio\Core\Team\Http\Controllers\ApiController::get
     * @covers \Ohio\Core\Team\Http\Controllers\ApiController::show
     * @covers \Ohio\Core\Team\Http\Controllers\ApiController::destroy
     * @covers \Ohio\Core\Team\Http\Controllers\ApiController::update
     * @covers \Ohio\Core\Team\Http\Controllers\ApiController::store
     * @covers \Ohio\Core\Team\Http\Controllers\ApiController::index
     */
    public function test()
    {

        $team1 = factory(Team::class)->make();

        $qbMock = $this->getPaginateQBMock(new PaginateRequest(), [$team1]);

        $teamRepository = m::mock(Team::class);
        $teamRepository->shouldReceive('find')->with(1)->andReturn($team1);
        $teamRepository->shouldReceive('find')->with(999)->andReturn(null);
        $teamRepository->shouldReceive('create')->andReturn($team1);
        $teamRepository->shouldReceive('query')->andReturn($qbMock);

        # construct
        $controller = new ApiController($teamRepository);
        $this->assertEquals($teamRepository, $controller->team);

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
        $this->assertEquals($team1->email, $data->email);

        # destroy team
        $response = $controller->destroy(1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());

        # update team
        $response = $controller->update(new UpdateRequest(), 1);
        $this->assertInstanceOf(JsonResponse::class, $response);

        # create team
        $response = $controller->store(new CreateRequest());
        $this->assertInstanceOf(JsonResponse::class, $response);

        # index
        $response = $controller->index(new Request());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($team1->email, $response->getData()->data[0]->email);

    }

}