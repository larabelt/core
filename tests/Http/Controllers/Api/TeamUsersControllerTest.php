<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Http\Exceptions\ApiException;
use Belt\Core\Team;
use Belt\Core\User;
use Belt\Core\Http\Requests\AttachUser;
use Belt\Core\Http\Requests\PaginateTeamUsers;
use Belt\Core\Http\Controllers\Api\TeamUsersController;
use Illuminate\Http\JsonResponse;

class TeamUsersControllerTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Controllers\Api\TeamUsersController::__construct
     * @covers \Belt\Core\Http\Controllers\Api\TeamUsersController::team
     * @covers \Belt\Core\Http\Controllers\Api\TeamUsersController::user
     * @covers \Belt\Core\Http\Controllers\Api\TeamUsersController::show
     * @covers \Belt\Core\Http\Controllers\Api\TeamUsersController::destroy
     * @covers \Belt\Core\Http\Controllers\Api\TeamUsersController::store
     * @covers \Belt\Core\Http\Controllers\Api\TeamUsersController::index
     */
    public function test()
    {
        $this->actAsSuper();

        Team::unguard();
        User::unguard();

        $team1 = factory(Team::class)->make();
        $team1->id = 1;
        $team1->users = new \Illuminate\Database\Eloquent\Collection();

        $user1 = factory(User::class)->make();
        $user1->id = 1;

        $user2 = factory(User::class)->make();
        $user2->id = 2;

        $team1->users->add($user1);

        $teamRepository = m::mock(Team::class);
        $teamRepository->shouldReceive('find')->with(1)->andReturn($team1);
        $teamRepository->shouldReceive('find')->with(999)->andReturn(null);

        $userRepository = m::mock(User::class);
        $userRepository->shouldReceive('find')->with(1)->andReturn($user1);
        $userRepository->shouldReceive('find')->with(2)->andReturn($user2);
        $userRepository->shouldReceive('find')->with(999)->andReturn(null);
        $userRepository->shouldReceive('create')->andReturn($user1);
        $userRepository->shouldReceive('query')->andReturn($this->getQBMock());

        # construct
        $controller = new TeamUsersController($teamRepository, $userRepository);
        $this->assertEquals($teamRepository, $controller->teams);
        $this->assertEquals($userRepository, $controller->users);

        # team
        $team = $controller->team(1);
        $this->assertEquals($team1->name, $team->name);
        try {
            $controller->team(999);
            $this->exceptionNotThrown();
        } catch (ApiException $e) {
            $this->assertEquals(404, $e->getStatusCode());
        }

        # user
        $user = $controller->user(1);
        $this->assertEquals($user1->email, $user->email);
        $user = $controller->user(1, $team);
        $this->assertEquals($user1->email, $user->email);
        try {
            $controller->user(999);
            $this->exceptionNotThrown();
        } catch (ApiException $e) {
            $this->assertEquals(404, $e->getStatusCode());
        }
        try {
            $controller->user(2, $team);
            $this->exceptionNotThrown();
        } catch (ApiException $e) {
            $this->assertEquals(404, $e->getStatusCode());
        }

        # show
        $response = $controller->show(1, 1);
        $this->assertEquals(200, $response->getStatusCode());

        # attach user
        $response = $controller->store(new AttachUser(['id' => 2]), 1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        try {
            // user already attached
            $controller->store(new AttachUser(['id' => 1]), 1);
            $this->exceptionNotThrown();
        } catch (ApiException $e) {
            $this->assertEquals(422, $e->getStatusCode());
        }

        # detach user
        $response = $controller->destroy(1, 1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
        try {
            // user already not attached
            $controller->destroy(1, 2);
            $this->exceptionNotThrown();
        } catch (ApiException $e) {
            $this->assertEquals(404, $e->getStatusCode());
        }

        # index
        $paginatorMock = $this->getPaginatorMock();
        $paginatorMock->shouldReceive('toArray')->andReturn([]);
        $controller = m::mock(TeamUsersController::class . '[paginator]', [$teamRepository, $userRepository]);
        $controller->shouldReceive('paginator')->andReturn($paginatorMock);
        $response = $controller->index(new PaginateTeamUsers(), 1);
        $this->assertEquals(200, $response->getStatusCode());
    }

}