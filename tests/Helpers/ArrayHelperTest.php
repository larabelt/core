<?php

use Belt\Core\Helpers\ArrayHelper;

class ArrayHelperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Core\Helpers\ArrayHelper::isAssociative
     */
    public function testisJson()
    {

        # isAssociative
        $this->assertTrue(ArrayHelper::isAssociative([
            'foo' => 'bar',
        ]));

        $this->assertFalse(ArrayHelper::isAssociative([]));
        $this->assertFalse(ArrayHelper::isAssociative(['foo', 'bar']));
    }
}
