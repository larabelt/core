<?php namespace Tests\Belt\Core\Unit\Behaviors;

use Belt\Core\Behaviors\CanEnable;
use Tests\Belt\Core\BeltTestCase;

class CanEnableTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Behaviors\CanEnable::disable
     * @covers \Belt\Core\Behaviors\CanEnable::enable
     * @covers \Belt\Core\Behaviors\CanEnable::isEnabled
     */
    public function test()
    {
        # disable
        CanEnableStub::disable();
        $this->assertEquals(false, CanEnableStub::isEnabled());

        # enable
        CanEnableStub::enable();
        $this->assertEquals(true, CanEnableStub::isEnabled());
    }

}

class CanEnableStub
{
    use CanEnable;
}