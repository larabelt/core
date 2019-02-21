<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Http\Exceptions;
use Belt\Core\Http\Requests\PaginateRequest;
use Belt\Core\Pagination\DefaultLengthAwarePaginator;
use Belt\Core\Team;
use Belt\Core\Tests\BeltTestCase;
use Belt\Core\Tests\CommonMocks;
use Belt\Core\User;
use Illuminate\Auth\Access\Response as AuthAccessResponse;
use Illuminate\Contracts\Auth\Access\Gate;
use Mockery as m;

class ApiControllerTest extends BeltTestCase
{
    use CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Controllers\ApiController::abort
     * @covers \Belt\Core\Http\Controllers\ApiController::paginator
     * @covers \Belt\Core\Http\Controllers\ApiController::getPaginateRequest
     * @covers \Belt\Core\Http\Controllers\ApiController::set
     * @covers \Belt\Core\Http\Controllers\ApiController::setIfNotEmpty
     * @covers \Belt\Core\Http\Controllers\ApiController::authorize
     * @covers \Belt\Core\Http\Controllers\ApiController::append
     * @covers \Belt\Core\Http\Controllers\ApiController::embed
     * @covers \Belt\Core\Http\Controllers\ApiController::itemEvent
     */
    public function test()
    {
        $controller = new ApiController();

        # abort 404
        try {
            $controller->abort(404);
        } catch (\Exception $e) {
            $this->assertInstanceOf(Exceptions\ApiNotFoundHttpException::class, $e);
        }

        # abort null
        try {
            $controller->abort(null);
        } catch (\Exception $e) {
            $this->assertInstanceOf(Exceptions\ApiException::class, $e);
        }

        # paginator
        $qbMock = $this->getPaginateQBMock();
        $paginator = $controller->paginator($qbMock, new PaginateRequest());
        $this->assertInstanceOf(DefaultLengthAwarePaginator::class, $paginator);

        # getPaginateRequest
        $request = $controller->getPaginateRequest(PaginateRequest::class, []);
        $this->assertInstanceOf(PaginateRequest::class, $request);
        $request = $controller->getPaginateRequest(PaginateRequest::class, []);
        $this->assertInstanceOf(PaginateRequest::class, $request);
        try {
            $controller->getPaginateRequest('something stupid');
        } catch (\Exception $e) {
            $somethingStupidHappened = true;
        }
        $this->assertTrue(isset($somethingStupidHappened));

        # set
        $user = new User();
        $controller->set($user, [
            'first_name' => 'clark',
            'last_name' => 'kent',
            'something_else' => 'does not matter',
        ], [
            'first_name',
            'last_name',
        ]);
        $this->assertEquals('CLARK', $user->first_name);
        $this->assertEquals('KENT', $user->last_name);

        # setIfNotEmpty
        $user = new User();
        $this->assertNull($user->password1);
        $this->assertNull($user->password2);
        $controller->setIfNotEmpty($user, [
            'password1' => '',
            'password2' => 'not-empty',
        ], [
            'password1',
            'password2',
        ]);
        $this->assertNull($user->password1);
        $this->assertNotNull($user->password2);

        $gate = m::mock(Gate::class);
        app()->instance(Gate::class, $gate);

        # authorization: allowed
        $gate->shouldReceive('allows')->with('foo', Team::class)->andReturn(false);
        $gate->shouldReceive('allows')->with('bar', Team::class)->andReturn(true);
        $response = $controller->authorize('bar', Team::class);
        $this->assertInstanceOf(AuthAccessResponse::class, $response);

        # authorization: denied
        $gate->shouldReceive('allows')->with('forbidden', Team::class)->andReturn(false);
        try {
            $controller->authorize('forbidden', Team::class);
            $this->exceptionNotThrown();
        } catch (\Exception $e) {

        }

//        # itemEvent
//        $item = new ApiControllerTestStub();
//        $event = new \Belt\Core\Events\ItemCreated($item, 'foo.created');
//        \Illuminate\Support\Facades\Event::shouldReceive('dispatch')->with('foo.created', $event);
//        $controller->itemEvent('created', $item);

        # append
        $item1 = m::mock(\Illuminate\Database\Eloquent\Model::class);
        $item1->shouldReceive('append')->with(['foo', 'bar'])->andReturnSelf();
        $controller->append(new \Illuminate\Http\Request(['append' => 'foo,bar']), $item1);

        # append
        $item2 = m::mock(\Illuminate\Database\Eloquent\Model::class);
        $item2->shouldReceive('getAttribute')->with('foo')->andReturnSelf();
        $item2->shouldReceive('getAttribute')->with('bar')->andReturnSelf();
        $controller->embed(new \Illuminate\Http\Request(['embed' => 'foo,bar']), $item2);
    }

}

class ApiControllerTestStub extends \Illuminate\Database\Eloquent\Model
{
    public function getMorphClass()
    {
        return 'foo';
    }
}