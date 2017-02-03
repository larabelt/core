<?php

use Mockery as m;
use Ohio\Core\Testing;
use Ohio\Core\Helpers\MorphHelper;
use Ohio\Core\Http\Controllers\Api\ParamsController;
use Ohio\Core\Http\Exceptions\ApiException;
use Ohio\Core\Http\Requests;
use Ohio\Core\Param;
use Ohio\Core\Behaviors\ParamableInterface;
use Ohio\Core\Behaviors\ParamableTrait;
use Illuminate\Database\Eloquent\Model;

class ParamsControllerTest extends Testing\OhioTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\Http\Controllers\Api\ParamsController::__construct
     * @covers \Ohio\Core\Http\Controllers\Api\ParamsController::param
     * @covers \Ohio\Core\Http\Controllers\Api\ParamsController::paramable
     * @covers \Ohio\Core\Http\Controllers\Api\ParamsController::show
     * @covers \Ohio\Core\Http\Controllers\Api\ParamsController::destroy
     * @covers \Ohio\Core\Http\Controllers\Api\ParamsController::store
     * @covers \Ohio\Core\Http\Controllers\Api\ParamsController::update
     * @covers \Ohio\Core\Http\Controllers\Api\ParamsController::index
     */
    public function test()
    {
        $this->actAsSuper();

        // mock page
        $section1 = new ParamsControllerTestStub();
        $section1->id = 1;

        // mock params
        Param::unguard();
        $param1 = factory(Param::class)->make();
        $param1->id = 1;
        $param2 = factory(Param::class)->make();
        $param2->id = 2;
        $section1->params = new \Illuminate\Database\Eloquent\Collection();
        $section1->params->add($param1);

        // mocked dependencies
        $nullQB = $this->getQBMock();
        $nullQB->shouldReceive('first')->andReturn(null);
        $param1QB = $this->getQBMock();
        $param1QB->shouldReceive('first')->andReturn($param1);
        $param2QB = $this->getQBMock();
        $param2QB->shouldReceive('first')->andReturn($param2);

        $paramsQB = $this->getQBMock();
        $paramsQB->shouldReceive('where')->with('paramable_type', 'sections')->andReturnSelf();
        $paramsQB->shouldReceive('where')->with('paramable_id', 1)->andReturnSelf();

        $paramsQB->shouldReceive('where')->with('params.id', 999)->andReturn($nullQB);
        $paramsQB->shouldReceive('where')->with('params.id', 1)->andReturn($param1QB);
        $paramsQB->shouldReceive('where')->with('params.id', 2)->andReturn($param2QB);

        $paramRepo = m::mock(Param::class);
        $paramRepo->shouldReceive('query')->andReturn($paramsQB);

        $morphHelper = m::mock(MorphHelper::class);
        $morphHelper->shouldReceive('morph')->with('sections', 1)->andReturn($section1);
        $morphHelper->shouldReceive('morph')->with('sections', 999)->andReturn(null);

        # construct
        $controller = new ParamsController($paramRepo, $morphHelper);
        $this->assertEquals($paramRepo, $controller->params);
        $this->assertEquals($morphHelper, $controller->morphHelper);

        # param
        $param = $controller->param(1);
        $this->assertEquals($param1->name, $param->name);
        $param = $controller->param(1, $section1);
        $this->assertEquals($param1->name, $param->name);
        try {
            $controller->param(999);
            $this->exceptionNotThrown();
        } catch (ApiException $e) {
            $this->assertEquals(404, $e->getStatusCode());
        }

        # paramable
        $section = $controller->paramable('sections', 1);
        $this->assertEquals($section1->name, $section->name);
        try {
            $controller->paramable('sections', 999);
            $this->exceptionNotThrown();
        } catch (ApiException $e) {
            $this->assertEquals(404, $e->getStatusCode());
        }

        # show
        $response = $controller->show('sections', 1, 1);
        $this->assertEquals(200, $response->getStatusCode());

        # store param
        $response = $controller->store(new Requests\StoreParam(['key' => 'foo', 'value' => 'bar']), 'sections', 1);
        $this->assertEquals(201, $response->getStatusCode());

        # delete param
        $response = $controller->destroy('sections', 1, 1);
        $this->assertEquals(204, $response->getStatusCode());

        # update
        $response = $controller->update(new Requests\UpdateParam(), 'sections', 1, 1);
        $this->assertEquals(200, $response->getStatusCode());

        # index
        $paginatorMock = $this->getPaginatorMock();
        $paginatorMock->shouldReceive('toArray')->andReturn([]);
        $controller = m::mock(ParamsController::class . '[paginator]', [$paramRepo, $morphHelper]);
        $controller->shouldReceive('paginator')->andReturn($paginatorMock);
        $response = $controller->index(new Requests\PaginateParams(), 'sections', 1);
        $this->assertEquals(200, $response->getStatusCode());
    }

}

class ParamsControllerTestStub extends Model
    implements ParamableInterface
{
    protected $guarded = [];

    use ParamableTrait;

    public function getMorphClass()
    {
        return 'sections';
    }
}