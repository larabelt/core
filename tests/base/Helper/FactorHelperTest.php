<?php

use Ohio\Core\Base\Helper\FactoryHelper;

class FactoryHelperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\Base\Helper\FactoryHelper::popImage
     */
    public function test()
    {
        $images = [
            'one',
            'two',
            'three',
        ];

        FactoryHelper::$images = $images;

        $image = FactoryHelper::popImage();

        $this->assertTrue(in_array($image, $images));
        $this->assertEquals(2, count(FactoryHelper::$images));
    }
}
