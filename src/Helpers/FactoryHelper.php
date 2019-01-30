<?php

namespace Belt\Core\Helpers;

use Belt\Content\Adapters\AdapterFactory;
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
    public static $adapter;

    /**
     * @var array
     */
    public static $images = [];

    /**
     * @param $adapter
     */
    public static function setAdapter($adapter)
    {
        static::$adapter = $adapter;
    }

    /**
     * @return \Belt\Content\Adapters\BaseAdapter
     * @throws \Exception
     */
    public static function adapter()
    {
        $adapter = static::$adapter ?: AdapterFactory::up();

        return static::$adapter = $adapter;
    }

    /**
     * @param null $images
     * @return null
     * @throws \Exception
     */
    public static function setImages($images = null, $limit = 2)
    {
        if ($images) {
            static::$images = $images;
        }

        if (count(static::$images) < $limit) {
            static::loadImages($limit);
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    public static function loadImages($limit = 10)
    {
        $adapter = static::adapter();
        //$adapter->disk->delete('belt/database/images');

        foreach ($adapter->disk->allFiles('belt/database/images') as $path) {
            static::$images[] = "storage/app/public/$path";
        }

        if (count(static::$images) < $limit) {
            for ($i = 0; $i < $limit; $i++) {
                static::$images[] = static::addImage();
            }
        }
    }

    /**
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public static function addImage($params = [])
    {
        $width = array_get($params, 'width', 640);
        $height = array_get($params, 'height', 480);
        $category = array_get($params, 'category', null);

        $adapter = static::adapter();
        $faker = Faker\Factory::create();
        $filename = $faker->image('/tmp', $width, $height, $category, false);
        $adapter->disk->put("belt/database/images/$filename", file_get_contents("/tmp/$filename"));

        return "storage/app/public/belt/database/images/$filename";
    }

    public static function uploadImage($path, $filename = null, $upload = true)
    {
        $adapter = static::adapter();

        $filename = $filename ?: basename($path);

        $fileInfo = new UploadedFile(base_path($path), $filename);

        // copy file in new location
        if ($upload) {
            $result = $adapter->upload('uploads', $fileInfo, $filename);
        } else {
            $result = $adapter->__create($path, $fileInfo, $filename);
            $result['path'] = 'local/uploads';
        }

        return $result;
    }

    /**
     * @return string
     */
    public static function getRandomImage()
    {
        shuffle(static::$images);

        return head(static::$images);
    }

}