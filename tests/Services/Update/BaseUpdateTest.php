<?php

use Belt\Core\Services\Update\BaseUpdate;
use Belt\Core\Testing;

class BaseUpdateTest extends Testing\BeltTestCase
{
    /**
     * @covers \Belt\Core\Services\Update\BaseUpdate::__construct
     * @covers \Belt\Core\Services\Update\BaseUpdate::up
     * @covers \Belt\Core\Services\Update\BaseUpdate::option
     * @covers \Belt\Core\Services\Update\BaseUpdate::argument
     */
    public function test()
    {
        $stub = new BaseUpdateStub([
            'options' => [
                'foo=bar',
                'hello',
                'world',
            ]
        ]);
        $this->assertEquals('foo', $stub->up());

        # option
        $this->assertEquals('bar', $stub->option('foo'));

        # argument
        $this->assertEquals('hello', $stub->argument('arg1'));
        $this->assertEquals('world', $stub->argument('arg2'));
        $this->assertEquals('default', $stub->argument('missing', 'default'));
    }

}

class BaseUpdateStub extends BaseUpdate
{
    /**
     * @var array
     */
    public $argumentMap = [
        'arg1',
        'arg2',
    ];

    public function up()
    {
        return 'foo';
    }
}