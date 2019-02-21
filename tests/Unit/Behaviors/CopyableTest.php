<?php namespace Tests\Belt\Core\Unit\Behaviors;

use Belt\Core\Behaviors\Copyable;
use Belt\Core\Tests;

class CopyableTest extends Tests\BeltTestCase
{

    /**
     * @covers \Belt\Core\Behaviors\Copyable::setIsCopy
     * @covers \Belt\Core\Behaviors\Copyable::getIsCopy
     */
    public function test()
    {
        $copyable = new CopyableTestStub();

        # getIsCopy
        $this->assertFalse($copyable->getIsCopy());

        # setIsCopy
        $copyable->setIsCopy(true);
        $this->assertTrue($copyable->getIsCopy());

    }

}

class CopyableTestStub extends Tests\BaseModelStub
{
    use Copyable;

}