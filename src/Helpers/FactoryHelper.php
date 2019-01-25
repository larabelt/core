<?php

namespace Belt\Core\Helpers;

use Faker;

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
     * @return string
     */
    public static function popImage()
    {
        shuffle(static::$images);

        return head(static::$images);
    }

    /**
     * @param $adapter
     * @return mixed
     */
    public static function loadImages($adapter)
    {
        $images = FactoryHelper::$images ?: $adapter->disk->allFiles('belt/database/images');

        if (!$images || count($images) < 10) {
            $adapter->disk->delete('belt/database/images');
            $faker = Faker\Factory::create();
            for ($i = 0; $i < 5; $i++) {
                $filename = $faker->image('/tmp', 640, 480, null, false);
                $adapter->disk->put("belt/database/images/$filename", file_get_contents("/tmp/$filename"));
            }
            $images = $adapter->disk->allFiles('belt/database/images');
        }

        return static::$images = $images;
    }

}