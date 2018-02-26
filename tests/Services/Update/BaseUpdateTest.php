<?php

use Belt\Core\Services\Update\BaseUpdate;
use Belt\Core\Testing;

class BaseUpdateTest extends Testing\BeltTestCase
{
    /**
     * @covers \Belt\Core\Services\Update\BaseUpdate::__construct
     * @covers \Belt\Core\Services\Update\BaseUpdate::up
     */
    public function test()
    {
        $stub = new BaseUpdateStub();
        $this->assertEquals('foo', $stub->up());
    }

}

class BaseUpdateStub extends BaseUpdate
{
    public function up()
    {
        return 'foo';
    }
}