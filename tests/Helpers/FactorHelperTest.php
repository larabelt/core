<?php

use Belt\Core\Helpers\FactoryHelper;

class FactoryHelperTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @covers \Belt\Core\Helpers\FactoryHelper::loadImages
     * @covers \Belt\Core\Helpers\FactoryHelper::getRandomImage
     */
    public function test()
    {
        $images = [
            'one',
            'two',
            'three',
        ];

        FactoryHelper::setImages($images);

        $image = FactoryHelper::getRandomImage();

        $this->assertTrue(in_array($image, $images));
        $this->assertEquals(count($images), count(FactoryHelper::getImages()));
    }
}
