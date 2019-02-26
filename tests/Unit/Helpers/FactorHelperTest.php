<?php namespace Tests\Belt\Core\Unit\Helpers;

use Belt\Content\Adapters\BaseAdapter;
use Belt\Core\Helpers\FactoryHelper;
use Tests\Belt\Core;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Mockery as m;

class FactoryHelperTest extends \Tests\Belt\Core\BeltTestCase
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
     * @covers \Belt\Core\Helpers\FactoryHelper::getUploadedFile
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

        # getUploadedFile
        $path = realpath(__DIR__ . '/../../assets/test.jpg');
        $fileInfo = new UploadedFile($path, 'foo.jpg');
        $this->assertEquals($fileInfo, $helper->getUploadedFile($path, 'foo.jpg'));

        // fully upload image
        $path = realpath(__DIR__ . '/../../assets/test.jpg');
        $fileInfo = new UploadedFile($path, 'foo.jpg');
        $adapter = m::mock(BaseAdapter::class);
        $adapter->shouldReceive('upload')->once()->with('uploads', $fileInfo, 'foo.jpg')->andReturn(['cool']);
        $helper = m::mock(FactoryHelper::class . '[getUploadedFile]');
        $helper->shouldReceive('getUploadedFile')->andReturn($fileInfo);
        $helper->setAdapter($adapter);
        $this->assertEquals(['cool'], $helper->uploadImage($path, 'foo.jpg'));

        // semi upload image
        $path = realpath(__DIR__ . '/../../assets/test.jpg');
        $fileInfo = new UploadedFile($path, 'foo.jpg');
        $adapter = m::mock(BaseAdapter::class);
        $adapter->shouldReceive('__create')->once()->with($path, $fileInfo, 'foo.jpg')->andReturn(['foo' => 'bar']);
        $helper = m::mock(FactoryHelper::class . '[getUploadedFile]');
        $helper->shouldReceive('getUploadedFile')->andReturn($fileInfo);
        $helper->setAdapter($adapter);
        $this->assertEquals(['foo' => 'bar', 'path' => 'local/uploads'], $helper->uploadImage($path, 'foo.jpg', false));

        // load images
        $disk = m::mock(Filesystem::class);
        $disk->shouldReceive('allFiles')->once()->with('belt/database/images')->andReturn(['test1.jpg']);
        $adapter = m::mock(BaseAdapter::class);
        $adapter->disk = $disk;
        $helper = m::mock(FactoryHelper::class . '[addImage]');
        $helper->setImages([]);
        $helper->shouldReceive('addImage')->times(9)->andReturn('test*.jpg');
        $helper->setAdapter($adapter);
        $helper->loadImages();
        $this->assertEquals(10, count($helper->getImages()));

    }
}
