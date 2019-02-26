<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Middleware\ActiveTeam;
use Belt\Core\Services\ActiveTeamService;
use Tests\Belt\Core\BeltTestCase;
use Belt\Core\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Mockery as m;

class ActiveTeamTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Middleware\ActiveTeam::__construct
     * @covers \Belt\Core\Http\Middleware\ActiveTeam::service
     * @covers \Belt\Core\Http\Middleware\ActiveTeam::handle
     */
    public function test()
    {

        $request = new Request([]);
        $next = function ($request) {
            if ($request instanceof Request) {
                return true;
            }
            return false;
        };
        $user = factory(User::class)->make();
        $guard = m::mock(Guard::class);
        $guard->shouldReceive('user')->andReturn($user);

        # service
        $middleware = new ActiveTeam($guard);
        $this->assertInstanceOf(ActiveTeamService::class, $middleware->service($request));

        # handle (no active team)
        $middleware->handle($request, $next);

        # handle (cancel team-mode)
        $request = new Request(['team_id' => 0]);
        $service = m::mock(ActiveTeamService::class . '[forgetTeam]');
        $service->shouldReceive('forgetTeam')->twice()->andReturnSelf();
        $middleware->service = $service;
        $middleware->handle($request, $next);

        # handle (set active team, authorized)
        $request = new Request(['team_id' => 1]);
        $service = m::mock(ActiveTeamService::class . '[forgetTeam,isAuthorized,setTeam,getActiveTeamId,getDefaultTeamId]');
        $service->shouldReceive('forgetTeam')->once()->andReturnSelf();
        $service->shouldReceive('isAuthorized')->once()->andReturn(true);
        $service->shouldReceive('setTeam')->once()->andReturnSelf();
        $service->shouldReceive('getActiveTeamId')->once()->andReturnNull();
        $service->shouldReceive('getDefaultTeamId')->once()->andReturn(1);
        $middleware->service = $service;
        $middleware->handle($request, $next);

        # handle (set active team, not-authorized)
        $request = new Request(['team_id' => 1]);
        $service = m::mock(ActiveTeamService::class . '[forgetTeam,getActiveTeamId,isAuthorized]');
        $service->shouldReceive('forgetTeam')->once()->andReturnSelf();
        $service->shouldReceive('getActiveTeamId')->once()->andReturn(2);
        $service->shouldReceive('isAuthorized')->once()->andReturn(false);
        $middleware->service = $service;
        try {
            $middleware->handle($request, $next);
            $this->exceptionNotThrown();
        } catch (\Exception $e) {

        }


    }

}