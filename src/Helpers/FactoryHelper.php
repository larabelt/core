<?php

namespace Belt\Core\Helpers;

use Belt\Content\Adapters\AdapterFactory;
use Belt\Content\Adapters\BaseAdapter;
use Faker;
use Illuminate\Http\UploadedFile;

/**
 * Class FactoryHelper
 * @package Belt\Core\Helpers
 */
class FactoryHelper
{

    /**
     * @var array
     */
    public static $ids = [];

    /**
     * @var array
     */
    public static $images = [];

    /**
     * @var BaseAdapter
     */
    public $adapter;

    /**
     * @var Faker\Generator
     */
    public $faker;

    /**
     * @param $adapter
     * @return $this
     */
    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * @return BaseAdapter
     * @throws \Exception
     */
    public function getAdapter()
    {
        $adapter = $this->adapter ?: AdapterFactory::up();

        return $this->adapter = $adapter;
    }

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem|\Illuminate\Filesystem\FilesystemAdapter
     * @throws \Exception
     */
    public function disk()
    {
        return $this->getAdapter()->disk;
    }

    /**
     * @param $faker
     * @return $this
     */
    public function setFaker($faker)
    {
        $this->faker = $faker;

        return $this;
    }

    /**
     * @return Faker\Generator
     */
    public function getFaker()
    {
        $faker = $this->faker ?: Faker\Factory::create();

        return $this->faker = $faker;
    }

    /**
     * @param array $images
     * @return $this
     */
    public function setImages($images = [])
    {
        static::$images = $images;

        return $this;
    }

    /**
     * @return array
     */
    public function getImages()
    {
        return static::$images;
    }

    /**
     * @return string
     */
    public function getRandomImage()
    {
        shuffle(static::$images);

        return head(static::$images);
    }

    /**
     * @param bool $force
     * @param int $limit
     * @return $this
     * @throws \Exception
     */
    public function loadImages($force = false, $limit = 10)
    {
        if (count(static::$images) < $limit || $force) {

            foreach ($this->disk()->allFiles('belt/database/images') as $path) {
                static::$images[] = "storage/app/public/$path";
            }

            $count = count(static::$images);
            if ($count < $limit) {
                for ($i = $count; $i < $limit; $i++) {
                    static::$images[] = $this->addImage();
                }
            }

        }

        return $this;
    }

    /**
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public function addImage($params = [])
    {
        $width = array_get($params, 'width', 640);
        $height = array_get($params, 'height', 480);
        $category = array_get($params, 'category', null);

        $filename = $this->getFaker()->image('/tmp', $width, $height, $category, false);
        $this->disk()->put("belt/database/images/$filename", file_get_contents("/tmp/$filename"));

        return "storage/app/public/belt/database/images/$filename";
    }

    /**
     * @param $path
     * @param $filename
     * @return UploadedFile
     */
    public function getUploadedFile($path, $filename)
    {
        return new UploadedFile($path, $filename);
    }

    /**
     * @param $path
     * @param null $filename
     * @param bool $upload
     * @return array|null
     * @throws \Exception
     */
    public function uploadImage($path, $filename = null, $upload = true)
    {
        $filename = $filename ?: basename($path);

        $fileInfo = $this->getUploadedFile($path, $filename);

        // copy file in new location
        if ($upload) {
            $result = $this->getAdapter()->upload('uploads', $fileInfo, $filename);
        } else {
            $result = $this->getAdapter()->__create($path, $fileInfo, $filename);
            $result['path'] = 'local/uploads';
        }

        return $result;
    }


}