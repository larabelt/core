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
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::getDefaultTemplateKey
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::setTemplateAttribute
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::getTemplateAttribute
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::getSubtypeConfigPrefix
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::getSubtypeConfig
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::getTemplateGroup
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::getTemplateViewAttribute
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::reconcileTemplateParams
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::getParamConfig
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::getConfigAttribute
     * @covers \Belt\Core\Behaviors\IncludesSubtypes::bootIncludesSubtypes
     */
    public function test()
    {
        # bootIncludesSubtypes
        IncludesSubtypesTestStub::bootIncludesSubtypes();

        $templateStub = new IncludesSubtypesTestStub();

        # bootIncludesSubtypes
        $templateStub->bootIncludesSubtypes();

        # template
        $templateStub->setTemplateAttribute(' Test ');
        $this->assertEquals('test', $templateStub->template);

        # getTemplateGroup
        $this->assertEquals('pages', $templateStub->getTemplateGroup());

        # template_view
        app()['config']->set('belt.templates.pages', [
            'default' => [
                'foo' => 'bar',
                'path' => 'belt-content::pages.sections.default',
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
            'pagetest' => 'belt-content::pages.sections.test',
        ]);
        $templateStub->template = 'missing';
        $this->assertEquals('belt-content::pages.sections.default', $templateStub->template_view);
        $templateStub->template = 'PageTest';
        $this->assertEquals('belt-content::pages.sections.test', $templateStub->template_view);

        # getSubtypeConfig
        $templateStub->template = 'default';
        $this->assertEquals('bar', $templateStub->getSubtypeConfig('foo'));
        $this->assertEquals('some-default', $templateStub->getSubtypeConfig('missing', 'some-default'));

        # template_view (exception due to missing config)
        $missingStub = new IncludesSubtypesTest2Stub();
        try {
            $missingStub->template_view;
            $this->exceptionNotThrown();
        } catch (\Exception $e) {

        }

        # reconcileTemplateParams where not paramable
        $notParamableStub = new IncludesSubtypesTest2Stub();
        $notParamableStub->reconcileTemplateParams();

        /**
         * reconcileTemplateParams where paramable
         *
         * class param will remain unchanged
         * icon param value will be overwritten b/c current value is not in config
         * foo will be added as a new param with default value
         */
        $templateStub = new IncludesSubtypesTest3Stub();
        $templateStub->reconcileTemplateParams();

        # getDefaultTemplateKey
        app()['config']->set('belt.templates.pages', [
            'pagetest' => 'belt-content::pages.sections.test',
            'pagetest2' => 'belt-content::pages.sections.test',
        ]);
        $templateStub = new IncludesSubtypesTestStub();
        $this->assertEquals('pagetest', $templateStub->getDefaultTemplateKey());

        # getSubtypeConfigPrefix
        $this->assertEquals('belt.templates.pages', $templateStub->getSubtypeConfigPrefix());

        # getTemplateAttribute
        $templateStub->setAttribute('template', 'test');
        $this->assertEquals('test', $templateStub->template);

        # getParamConfig
        app()['config']->set('belt.templates.pages.foo', [
            'name' => 'test',
            'params' => [
                'foo' => 'bar'
            ],
        ]);
        $templateStub->template = 'foo';
        $this->assertEquals(config('belt.templates.pages.foo.params'), $templateStub->getParamConfig());

        # getConfigAttribute
        $this->assertEquals(config('belt.templates.pages.foo'), $templateStub->config);
    }

    public function tearDown()
    {
        m::close();
    }

}

class IncludesSubtypesTestStub extends Model
{
    use IncludesSubtypes;

    public function getMorphClass()
    {
        return 'pages';
    }
}

class IncludesSubtypesTest2Stub extends Model
{
    use IncludesSubtypes;

    public function getMorphClass()
    {
        return 'something-else-that-is-missing-a-config-file';
    }
}

class IncludesSubtypesTest3Stub extends Model implements ParamableInterface
{
    use IncludesSubtypes;

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