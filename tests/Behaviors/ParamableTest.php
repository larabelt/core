<?php

use Mockery as m;
use Belt\Core\Behaviors\Paramable;
use Belt\Core\Param;
use Belt\Core\Testing;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Collection;

class ParamableTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Behaviors\Paramable::params
     * @covers \Belt\Core\Behaviors\Paramable::saveParam
     * @covers \Belt\Core\Behaviors\Paramable::param
     */
    public function test()
    {
        // init
        Param::unguard();
        $paramable = new ParamableStub();
        $paramable->params = new Collection();
        $paramable->params->add(new Param(['key' => 'foo', 'value' => 'bar']));

        # params
        $this->assertInstanceOf(MorphMany::class, $paramable->params());

        # param
        $this->assertEquals('bar', $paramable->param('foo'));
        $this->assertEquals('default', $paramable->param('missing', 'default'));
        $this->assertEquals(null, $paramable->param('invalid'));

        # saveParam (update)
        $param = m::mock(Param::class . '[update]');
        $param->setAttribute('key', 'foo');
        $param->shouldReceive('update')->once()->with(['value' => 'new'])->andReturnSelf();
        $paramable->params = new Collection();
        $paramable->params->add($param);
        $paramable->saveParam('foo', 'new');

        # saveParam (create)
        $morphMany = m::mock(MorphMany::class);
        $morphMany->shouldReceive('save')->once();
        $paramable = m::mock(ParamableStub::class . '[params]');
        $paramable->params = new Collection();
        $paramable->shouldReceive('params')->once()->andReturn($morphMany);
        $paramable->saveParam('missing', 'test');
    }

}

class ParamableStub extends Testing\BaseModelStub
{
    use Paramable;

    public function load($relations)
    {
        
    }

}