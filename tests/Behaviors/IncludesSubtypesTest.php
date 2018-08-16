<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Behaviors\Paramable;
use Belt\Core\Behaviors\ParamableInterface;
use Belt\Core\Param;
use Belt\Core\Behaviors\IncludesSubtypes;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class IncludesSubtypesTest extends Testing\BeltTestCase
{

    /**
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::bootIncludesSubtypes
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::getDefaultSubtypeKey
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::setSubtypeAttribute
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::getSubtypeAttribute
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::getSubtypeConfigPrefix
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::getSubtypeConfig
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::getSubtypeGroup
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::getSubtypeViewAttribute
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::reconcileSubtypeParams
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::getParamGroupsConfig
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::getParamConfig
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::getConfigAttribute
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::bootIncludesSubtypes
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::config
     */
    public function test()
    {
        # bootIncludesSubtypes
        IncludesSubtypesTestStub::bootIncludesSubtypes();

        $subtypeStub = new IncludesSubtypesTestStub();

        # bootIncludesSubtypes
        $subtypeStub->bootIncludesSubtypes();

        # subtype
        $subtypeStub->setSubtypeAttribute(' Test ');
        $this->assertEquals('test', $subtypeStub->subtype);

        # getSubtypeGroup
        $this->assertEquals('pages', $subtypeStub->getSubtypeGroup());

        # subtype_view
        app()['config']->set('belt.subtypes.pages', [
            'default' => [
                'foo' => 'bar',
                'path' => 'belt-content::pages.subtypes.default',
                'params' => [
                    'class' => [
                        'options' => [
                            'col-md-3' => 'default',
                            'col-md-12' => 'wide',
                        ]
                    ],
                    'icon' => [
                        'default' => 'default',
                        'special' => 'special',
                    ],
                    'foo' => [
                        'type' => 'text',
                        'default' => 'bar',
                        'other' => 'other',
                    ],
                ]
            ],
            'pagetest' => 'belt-content::pages.subtypes.test',
        ]);
        $subtypeStub->subtype = 'missing';
        $this->assertEquals('belt-content::pages.subtypes.default', $subtypeStub->subtype_view);
        $subtypeStub->subtype = 'PageTest';
        $this->assertEquals('belt-content::pages.subtypes.test', $subtypeStub->subtype_view);

        # getSubtypeConfig
        $subtypeStub->subtype = 'default';
        $this->assertEquals('bar', $subtypeStub->getSubtypeConfig('foo'));
        $this->assertEquals('some-default', $subtypeStub->getSubtypeConfig('missing', 'some-default'));

        # subtype_view (exception due to missing config)
        $missingStub = new IncludesSubtypesTest2Stub();
        try {
            $missingStub->subtype_view;
            $this->exceptionNotThrown();
        } catch (\Exception $e) {

        }

        # reconcileSubtypeParams where not paramable
        $notParamableStub = new IncludesSubtypesTest2Stub();
        $notParamableStub->reconcileSubtypeParams();

        /**
         * reconcileSubtypeParams where paramable
         *
         * class param will remain unchanged
         * icon param value will be overwritten b/c current value is not in config
         * foo will be added as a new param with default value
         */
        $subtypeStub = new IncludesSubtypesTest3Stub();
        $subtypeStub->reconcileSubtypeParams();

        # getDefaultSubtypeKey
        app()['config']->set('belt.subtypes.pages', [
            'pagetest' => 'belt-content::pages.sections.test',
            'pagetest2' => 'belt-content::pages.sections.test',
        ]);
        $subtypeStub = new IncludesSubtypesTestStub();
        $this->assertEquals('pagetest', $subtypeStub->getDefaultSubtypeKey());

        # getSubtypeConfigPrefix
        $this->assertEquals('belt.subtypes.pages', $subtypeStub->getSubtypeConfigPrefix());

        # getSubtypeAttribute
        $subtypeStub->setAttribute('subtype', 'test');
        $this->assertEquals('test', $subtypeStub->subtype);

        # getParamConfig
        app()['config']->set('belt.subtypes.pages.foo', [
            'name' => 'test',
            'param_groups' => [
                'hello' => 'world'
            ],
            'params' => [
                'foo' => 'bar'
            ],
        ]);
        $subtypeStub->subtype = 'foo';
        $this->assertEquals(config('belt.subtypes.pages.foo.params'), $subtypeStub->getParamConfig());

        # getParamGroupsConfig
        $this->assertEquals($subtypeStub->getSubtypeConfig('param_groups'), $subtypeStub->getParamGroupsConfig());

        # getConfigAttribute
        $this->assertEquals(config('belt.subtypes.pages.foo'), $subtypeStub->config);

        # config
        $this->assertEquals($subtypeStub->getSubtypeConfig('foo'), $subtypeStub->config('foo'));
    }

    public function tearDown()
    {
        m::close();
    }

}

class IncludesSubtypesTestStub extends Model
{
    use IncludesSubtypes;
    use IncludesSubtypes;
    use Paramable;

    public function getMorphClass()
    {
        return 'pages';
    }
}

class IncludesSubtypesTest2Stub extends Model
{
    use IncludesSubtypes;
    use Paramable;

    public function getMorphClass()
    {
        return 'something-else-that-is-missing-a-config-file';
    }
}

class IncludesSubtypesTest3Stub extends Model implements ParamableInterface
{
    use IncludesSubtypes;
    use Paramable;

    public function getMorphClass()
    {
        return 'pages';
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->params = new Collection();
        $this->params->add($this->mockParam('class', 'default'));
        $this->params->add($this->mockParam('icon', 'missing'));
    }

    public function mockParam($key, $value)
    {
        $param = m::mock(Param::class . '[getAttribute,update]');
        $param->shouldReceive('getAttribute')->with('key')->andReturn($key);
        $param->shouldReceive('getAttribute')->with('value')->andReturn($value);
        $param->shouldReceive('update')->andReturnSelf();

        return $param;
    }

    public function load($relations)
    {

    }

    public function params()
    {
        $builder = m::mock(Param::class);
        $builder->shouldReceive('create')->andReturn($this->mockParam('foo', 'value'));

        return $builder;
    }
}