<?php namespace Tests\Belt\Core\Unit\Services;

use Belt\Core\Services\FormService;
use Belt\Core\Tests;
use Mockery as m;

class FormServiceTest extends Tests\BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Services\FormService::subtypes
     * @covers \Belt\Core\Services\FormService::extension
     */
    public function test()
    {
        app()['config']->set('belt.subtypes.forms', [
            'test' => [
                'extension' => FormServiceTestExtension::class,
            ],
            'foo' => [],
            'bar' => [],
        ]);


        $service = new FormService();

        # subtypes
        $this->assertEquals(['bar', 'foo', 'test'], $service->subtypes());

        # extension
        $this->assertInstanceOf(FormServiceTestExtension::class, $service->extension('test'));
        $this->assertNull($service->extension('foo'));

    }

}

class FormServiceTestExtension extends \Belt\Core\Forms\BaseForm
{

}