<?php

use Belt\Core\Behaviors\Copyable;
use Belt\Core\Testing;

class CopyableTest extends Testing\BeltTestCase
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

class CopyableTestStub extends Testing\BaseModelStub
{
    use Copyable;

}