<?php

use Mockery as m;
use Ohio\Core\Behaviors\ParamableTrait;
use Ohio\Core\Param;
use Ohio\Core\Testing;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Collection;

class ParamableTraitTest extends Testing\OhioTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\Behaviors\ParamableTrait::params
     * @covers \Ohio\Core\Behaviors\ParamableTrait::saveParam
     * @covers \Ohio\Core\Behaviors\ParamableTrait::param
     */
    public function test()
    {
        // init
        Param::unguard();
        $paramable = new ParamableTraitStub();
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
        $paramable = m::mock(ParamableTraitStub::class . '[params]');
        $paramable->params = new Collection();
        $paramable->shouldReceive('params')->once()->andReturn($morphMany);
        $paramable->saveParam('missing', 'test');
    }

}

class ParamableTraitStub extends Testing\BaseModelStub
{
    use ParamableTrait;

}