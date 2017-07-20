<?php

use Mockery as m;
use Belt\Core\Behaviors\HasConfig;
use Belt\Core\Testing\BeltTestCase;
use Illuminate\Database\Eloquent\Model;

class HasConfigTest extends BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * covers \Belt\Core\Behaviors\HasConfig::configPath
     * covers \Belt\Core\Behaviors\HasConfig::configDefaults
     * covers \Belt\Core\Behaviors\HasConfig::setConfig
     * covers \Belt\Core\Behaviors\HasConfig::getConfig
     * covers \Belt\Core\Behaviors\HasConfig::config
     */
    public function test()
    {

        app()['config']->set('test.HasConfigTestStub', [
            'hello' => 'universe',
        ]);

        # configDefaults
        $stub = new HasConfigTestStub();
        $this->assertEquals([], $stub->configDefaults());

        # configPath
        $this->assertEquals('', $stub->configPath());

        # configDefaults
        # setConfig
        # getConfig
        # config
        $stub = new HasConfigTestStub2();
        $this->assertEquals('bar', $stub->config('foo'));
        $this->assertEquals('universe', $stub->config('hello'));
        $this->assertEquals('default', $stub->config('missing', 'default'));
        $this->assertNull($stub->config('other-missing'));
        $this->assertEquals('bar', array_get($stub->config(), 'foo'));
    }

}

class HasConfigTestStub extends Model
{
    use HasConfig;
}

class HasConfigTestStub2 extends HasConfigTestStub
{
    /**
     * {@inheritdoc}
     */
    public function configPath()
    {
        return 'test.HasConfigTestStub';
    }

    /**
     * @return array
     */
    public function configDefaults()
    {
        return [
            'foo' => 'bar',
            'hello' => 'world',
        ];
    }

}