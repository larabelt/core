<?php namespace Tests\Belt\Core\Unit\Behaviors;

use Belt\Core\Behaviors\Paramable;
use Belt\Core\Facades\MorphFacade;
use Belt\Core\Param;
use Belt\Core\Team;
use Belt\Core\Tests;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Mockery as m;

class ParamableTest extends Tests\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Behaviors\Paramable::bootParamable
     * @covers \Belt\Core\Behaviors\Paramable::hasParam
     * @covers \Belt\Core\Behaviors\Paramable::param
     * @covers \Belt\Core\Behaviors\Paramable::params
     * @covers \Belt\Core\Behaviors\Paramable::saveParam
     * @covers \Belt\Core\Behaviors\Paramable::paramQB
     * @covers \Belt\Core\Behaviors\Paramable::purgeDuplicateParams
     * @covers \Belt\Core\Behaviors\Paramable::morphParam
     * @covers \Belt\Core\Behaviors\Paramable::scopeHasParam
     * @covers \Belt\Core\Behaviors\Paramable::scopeHasDefinedParam
     * @covers \Belt\Core\Behaviors\Paramable::scopeHasDefinedParam
     * @covers \Belt\Core\Behaviors\Paramable::getParamConfig
     * @covers \Belt\Core\Behaviors\Paramable::getParamGroupsConfig
     */
    public function test()
    {
        // init
        Param::unguard();
        $paramable = new ParamableStub();
        $paramable->params = new Collection();
        $paramable->params->add(new Param(['key' => 'foo', 'value' => 'bar']));
        $paramable->params->add(new Param(['key' => 'hello', 'value' => null]));


        # bootParamable
        ParamableStub::bootParamable();

        # paramQB
        $this->assertInstanceOf(Builder::class, $paramable->paramQB());

        # params
        $this->assertInstanceOf(MorphMany::class, $paramable->params());

        # param
        $this->assertEquals('bar', $paramable->param('foo'));
        $this->assertEquals('default', $paramable->param('missing', 'default'));
        $this->assertEquals(null, $paramable->param('invalid'));

        # hasParam
        $this->assertTrue($paramable->hasParam('hello'));
        $this->assertFalse($paramable->hasParam('world'));

        # saveParam (create/update)
        $param = m::mock(Param::class . '[save]');
        $param->shouldReceive('save')->once()->andReturnSelf();
        $morphMany = m::mock(MorphMany::class);
        $morphMany->shouldReceive('firstOrNew')->once()->andReturn($param);
        $paramable = m::mock(ParamableStub::class . '[params]');

        $paramable::bootParamable();
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

        # scopeHasDefinedParam
        $paramable = new ParamableStub();
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('whereHas')->once()->with('params',
            m::on(function (\Closure $closure) {
                $qb = m::mock(Builder::class);
                $qb->shouldReceive('where')->with('params.key', 'test');
                $qb->shouldReceive('where')->with('params.value', '!=', '');
                $qb->shouldReceive('whereNotNull')->with('params.value');
                $closure($qb);
                return is_callable($closure);
            })
        );
        $paramable->scopeHasDefinedParam($qb, 'test');

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

        # getParamConfig
        $this->assertEquals([], $paramable->getParamConfig());

        # getParamGroupsConfig
        $this->assertEquals([], $paramable->getParamGroupsConfig());

    }

}

class ParamableStub extends Tests\BaseModelStub
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