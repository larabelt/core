<?php

use Mockery as m;
use Belt\Core\Behaviors\Paramable;
use Belt\Core\Param;
use Belt\Core\Team;
use Belt\Core\Testing;
use Belt\Core\Facades\MorphFacade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ParamableTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Behaviors\Paramable::param
     * @covers \Belt\Core\Behaviors\Paramable::params
     * @covers \Belt\Core\Behaviors\Paramable::saveParam
     * @covers \Belt\Core\Behaviors\Paramable::paramQB
     * @covers \Belt\Core\Behaviors\Paramable::purgeDuplicateParams
     * @covers \Belt\Core\Behaviors\Paramable::morphParam
     * @covers \Belt\Core\Behaviors\Paramable::scopeHasParam
     * @covers \Belt\Core\Behaviors\Paramable::scopeHasParamNotNull
     */
    public function test()
    {
        // init
        Param::unguard();
        $paramable = new ParamableStub();
        $paramable->params = new Collection();
        $paramable->params->add(new Param(['key' => 'foo', 'value' => 'bar']));

        # paramQB
        $this->assertInstanceOf(Builder::class, $paramable->paramQB());

        # params
        $this->assertInstanceOf(MorphMany::class, $paramable->params());

        # param
        $this->assertEquals('bar', $paramable->param('foo'));
        $this->assertEquals('default', $paramable->param('missing', 'default'));
        $this->assertEquals(null, $paramable->param('invalid'));

        # saveParam (create/update)
        $param = m::mock(Param::class . '[save]');
        $param->shouldReceive('save')->once()->andReturnSelf();
        $morphMany = m::mock(MorphMany::class);
        $morphMany->shouldReceive('firstOrNew')->once()->andReturn($param);
        $paramable = m::mock(ParamableStub::class . '[params]');
        $paramable->params = new Collection();
        $paramable->shouldReceive('params')->once()->andReturn($morphMany);
        $paramable->saveParam('missing', 'test');

        # purgeDuplicateParams
        Param::unguard();
        $param = new Param(['id' => 1, 'key' => 'foo', 'value' => 'bar']);
        $duplicate = m::mock(Param::class);
        $duplicate->shouldReceive('delete')->once()->andReturnNull();

        $duplicates = new Collection();
        $duplicates->add($duplicate);

        $paramQB = m::mock(Builder::class);
        $paramQB->shouldReceive('where')->once()->with('id', '!=', 1)->andReturnSelf();
        $paramQB->shouldReceive('where')->once()->with('paramable_type', 'paramable-stubs')->andReturnSelf();
        $paramQB->shouldReceive('where')->once()->with('paramable_id', 999)->andReturnSelf();
        $paramQB->shouldReceive('where')->once()->with('key', 'foo')->andReturnSelf();
        $paramQB->shouldReceive('get')->once()->andReturn($duplicates);

        $paramable = m::mock(ParamableStub::class . '[paramQB,getAttribute]');
        $paramable->shouldReceive('paramQB')->once()->andReturn($paramQB);
        $paramable->shouldReceive('getAttribute')->with('id')->andReturn(999);
        $paramable->shouldReceive('getAttribute')->with('key')->andReturn('test');
        $paramable->purgeDuplicateParams($param);

        # morphParam
        $team = factory(Team::class)->make();
        MorphFacade::shouldReceive('morph')->once()->with('teams', 1)->andReturn($team);
        $paramable = m::mock(ParamableStub::class . '[param]');
        $paramable->shouldReceive('param')->once()->with('teams')->andReturn(1);
        $this->assertEquals($team, $paramable->morphParam('teams'));

        # morphParam (exception)
        $paramable = m::mock(ParamableStub::class . '[param]');
        $paramable->shouldReceive('param')->once()->with('teams')->andReturn(false);
        try {
            $paramable->morphParam('teams');
            $this->exceptionNotThrown();
        } catch(\Exception $e) {

        }

        # scopeHasParamNotNull
        $paramable = new ParamableStub();
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('whereHas')->once()->with('params',
            m::on(function (\Closure $closure) {
                $qb = m::mock(Builder::class);
                $qb->shouldReceive('where')->with('params.key', 'test');
                $qb->shouldReceive('whereNotNull')->with('params.value');
                $closure($qb);
                return is_callable($closure);
            })
        );
        $paramable->scopeHasParamNotNull($qb, 'test');

        # scopeHasParam
        $paramable = new ParamableStub();
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('whereHas')->once()->with('params',
            m::on(function (\Closure $closure) {
                $qb = m::mock(Builder::class);
                $qb->shouldReceive('where')->with('params.key', 'foo');
                $qb->shouldReceive('where')->with('params.value', 'bar');
                $closure($qb);
                return is_callable($closure);
            })
        );
        $paramable->scopeHasParam($qb, 'foo', 'bar');

    }

}

class ParamableStub extends Testing\BaseModelStub
{
    use Paramable;

    public function load($relations)
    {

    }

    public function getMorphClass()
    {
        return 'paramable-stubs';
    }

}