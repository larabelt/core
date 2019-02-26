<?php namespace Tests\Belt\Core\Unit\Helpers;

use Belt\Core\Helpers\ConfigHelper;
use Tests\Belt\Core\BeltTestCase;

class ConfigHelperTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Helpers\ConfigHelper::config
     */
    public function testconfig()
    {

        app()['config']->set('path', [
            'default' => [
                'foo' => 'bar',
                'something' => 'else',
            ]
        ]);

        $config = ConfigHelper::config('path', 'default');
        $this->assertEquals('bar', array_get($config, 'foo'));

        $config = ConfigHelper::config('path', 'missing', 'default');
        $this->assertEquals('bar', array_get($config, 'foo'));

        try {
            ConfigHelper::config('path', 'missing', null, true);
            $this->exceptionNotThrown();
        } catch (\Exception $e) {

        }
    }
}
