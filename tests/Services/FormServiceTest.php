<?php

use Mockery as m;

use Belt\Core\Services\FormService;
use Belt\Core\Testing;

class FormServiceTest extends Testing\BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Services\FormService::keys
     * @covers \Belt\Core\Services\FormService::template
     */
    public function test()
    {
        app()['config']->set('belt.forms', [
            'test' => [
                'template' => FormServiceTestTemplate::class,
            ],
            'foo' => [],
            'bar' => [],
        ]);


        $service = new FormService();

        # keys
        $this->assertEquals(['bar', 'foo', 'test'], $service->keys());

        # template
        $this->assertInstanceOf(FormServiceTestTemplate::class, $service->template('test'));
        $this->assertNull($service->template('foo'));

    }

}

class FormServiceTestTemplate extends \Belt\Core\Forms\BaseForm
{

}