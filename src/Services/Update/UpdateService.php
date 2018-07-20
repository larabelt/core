<?php

namespace Belt\Core\Services\Update;

use Belt;
use Belt\Core\Behaviors\HasConsole;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Str;

/**
 * Class UpdateService
 * @package Belt\Core\Services
 */
class UpdateService
{
    use HasConsole, Macroable;

    /**
     * @var string
     */
    public $packageKey = 'core';

    /**
     * PublishService constructor.
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->console = array_get($options, 'console');

        $this->packageKey = array_get($options, 'package', 'core');

        $this->registerUpdates();
    }

    /**
     * Register updates
     *
     * zodeCoverageIgnore
     *
     * @param null $packageKey
     */
    public function registerUpdates($packageKey = null)
    {
        $packageKey = $packageKey ?: $this->packageKey;

        $package = app('belt')->packages($packageKey);

        $path = $package['dir'] . '/updates';

        if (file_exists($path)) {
            foreach (scandir($path) as $file) {
                if (str_contains($file, '.php')) {
                    $name = $this->getUpdateKey($file);
                    $fullpath = "$path/$file";
                    $this->registerUpdate($name, function ($service, $options = []) use ($fullpath) {
                        return $this->runUpdate($fullpath, $options);
                    });
                }
            }
        }
    }

    /**
     * @param $name
     * @param callable $macro
     */
    public static function registerUpdate($name, callable $macro)
    {
        static::macro(base64_encode($name), $macro);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function run($params)
    {
        $name = base64_encode($params[0]);

        if (static::hasMacro($name)) {
            unset($params[0]);
            return static::$name($this, $params);
        }
    }

    /**
     * Resolve a migration instance from a file.
     *
     * @param  string $file
     * @return object
     */
    public function getUpdateClass($path)
    {
        return sprintf('BeltUpdate%s', Str::studly($this->getUpdateKey($path)));
    }

    /**
     * Get the name of the migration.
     *
     * @param  string $path
     * @return string
     */
    public function getUpdateKey($path)
    {
        $stripped_name = str_replace('.php', '', basename($path));

        return implode('_', array_slice(explode('_', $stripped_name), 3));
    }

    /**
     * Find corresponding update file and run it
     *
     * @param $path
     * @param array $options
     * @return mixed
     */
    public function runUpdate($path, $options = [])
    {
        include $path;

        $class = $this->getUpdateClass($path);

        $params = [
            'console' => $this->console,
            'options' => $options,
        ];

        $updater = new $class($params);

        return $updater->up();
    }

}