<?php
namespace Belt\Core\Helpers;

use Belt;
use Illuminate\Filesystem\FilesystemManager;

/**
 * Class BeltHelper
 * @package Belt\Core\Helpers
 */
class BeltHelper
{

    /**
     * List of Loaded Belt Packages
     *
     * @var null|array
     */
    private static $enabled;

    /**
     * List of available Belt Pacakges
     *
     * @var array
     */
    private $available = [
        'core' => Belt\Core\BeltCoreServiceProvider::class,
        'content' => Belt\Content\BeltContentServiceProvider::class,
        'menu' => Belt\Menu\BeltMenuServiceProvider::class,
        'spot' => Belt\Spot\BeltSpotServiceProvider::class,
    ];

    /**
     * @return array
     */
    public function enabled()
    {
        if (!is_null(static::$enabled)) {
            return static::$enabled;
        }

        $loaded = app()->getLoadedProviders();

        $enabled = [];
        foreach ($this->available as $key => $class) {
            if (array_get($loaded, $class) === true) {
                $enabled[$key] = $class;
            }
        }

        return static::$enabled = $enabled;
    }

    /**
     * @param $providerClass
     * @return bool
     */
    public function uses($providerClass)
    {
        $enabled = $this->enabled();

        if (in_array($providerClass, $enabled)) {
            return true;
        }

        if (isset($enabled[$providerClass])) {
            return true;
        }

        return false;
    }

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public static function baseDisk()
    {
        app()['config']->set('filesystems.disks.base', ['driver' => 'local', 'root' => base_path()]);

        return (new FilesystemManager(app()))->disk('base');
    }

}