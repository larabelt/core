<?php

use Mockery as m;
use Belt\Core\Helpers\FactoryHelper;
use Belt\Core\Testing;
use Belt\Content\Adapters\BaseAdapter;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;

class FactoryHelperTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Helpers\FactoryHelper::setAdapter
     * @covers \Belt\Core\Helpers\FactoryHelper::getAdapter
     * @covers \Belt\Core\Helpers\FactoryHelper::disk
     * @covers \Belt\Core\Helpers\FactoryHelper::setFaker
     * @covers \Belt\Core\Helpers\FactoryHelper::getFaker
     * @covers \Belt\Core\Helpers\FactoryHelper::setImages
     * @covers \Belt\Core\Helpers\FactoryHelper::getImages
     * @covers \Belt\Core\Helpers\FactoryHelper::loadImages
     * @covers \Belt\Core\Helpers\FactoryHelper::addImage
     * @covers \Belt\Core\Helpers\FactoryHelper::uploadImage
     * @covers \Belt\Core\Helpers\FactoryHelper::getRandomImage
     */
    public function test()
    {
        $images = [
            'test1.jpg',
            'test2.jpg',
            'test3.jpg',
            'test4.jpg',
            'test5.jpg',
            'test6.jpg',
            'test7.jpg',
            'test8.jpg',
            'test9.jpg',
            'test10.jpg',
        ];

        $imagesWithPath = [
            'storage/app/public/test1.jpg',
            'storage/app/public/test2.jpg',
            'storage/app/public/test3.jpg',
            'storage/app/public/test4.jpg',
            'storage/app/public/test5.jpg',
            'storage/app/public/test6.jpg',
            'storage/app/public/test7.jpg',
            'storage/app/public/test8.jpg',
            'storage/app/public/test9.jpg',
            'storage/app/public/test10.jpg',
        ];

        $helper = new FactoryHelper();

        # get/set adapter
        $helper->setAdapter('foo');
        $this->assertEquals('foo', $helper->getAdapter());

        # disk
        $adapter = new \StdClass();
        $adapter->disk = 'foo';
        $helper->setAdapter($adapter);
        $this->assertEquals('foo', $helper->disk());

        # get/set faker
        $helper->setFaker('foo');
        $this->assertEquals('foo', $helper->getFaker());

        # get/set images
        $helper->setImages($images);
        $this->assertEquals($images, $helper->getImages());

        # get random image
        $helper->setImages($images);
        $image = $helper->getRandomImage();
        $this->assertTrue(in_array($image, $images));

        # add image
        //$tmpImage = __DIR__ . '../testing/test.jpg';
        file_put_contents('/tmp/foo', 'bar');
        $disk = m::mock(Filesystem::class);
        $disk->shouldReceive('put')->once()->with("belt/database/images/foo", 'bar')->andReturn($images);
        $adapter = m::mock(BaseAdapter::class);
        $adapter->disk = $disk;
        $helper->setAdapter($adapter);
        $faker = m::mock(\Faker\Generator::class);
        $faker->shouldReceive('image')->once()->with('/tmp', 10, 10, 'foo', false)->andReturn('foo');
        $helper->setFaker($faker);
        $this->assertEquals("storage/app/public/belt/database/images/foo", $helper->addImage(['width' => 10, 'height' => 10, 'category' => 'foo']));

        // fully upload image
        $path = 'vendor/larabelt/content/tests/testing/test.jpg';
        $fileInfo = new UploadedFile(base_path($path), 'foo.jpg');
        $adapter = m::mock(BaseAdapter::class);
        $adapter->shouldReceive('upload')->once()->with('upload', $fileInfo, 'foo.jpg')->andReturn(['cool']);
        $helper->setAdapter($adapter);
        $this->assertEquals(['cool'], $helper->uploadImage($path, 'foo.jpg'));


        return;

        # get/set adapter
        $helper->setAdapter('foo');
        $this->assertEquals('foo', $helper->getAdapter());

        # set/get images
        $helper->setImages($images);
        $this->assertEquals($images, $helper->getImages());

        # load images already saved locally
        $disk = m::mock(Filesystem::class);
        $disk->shouldReceive('allFiles')->once()->with('belt/database/images')->andReturn($images);
        $adapter = m::mock(BaseAdapter::class);
        $adapter->disk = $disk;
        $helper->setAdapter($adapter);
        $helper->setImages([]);
        $this->assertEquals([], $helper->getImages());
        $helper->loadImages();
        $this->assertEquals($imagesWithPath, $helper->getImages());

        # get random image
        $image = $helper->getRandomImage();
        $this->assertTrue(in_array($image, $imagesWithPath));

        # load images remotely and save/upload locally
        $disk = m::mock(Filesystem::class);
        $disk->shouldReceive('allFiles')->once()->with('belt/database/images')->andReturn([]);
        $adapter = m::mock(BaseAdapter::class);
        $adapter->disk = $disk;
        $helper->setAdapter($adapter);
        $helper->setImages([]);
        $helper->loadImages();
        $this->assertEquals($imagesWithPath, $helper->getImages());

    }
}
