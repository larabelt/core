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
     * @var array
     */
    public $path;

    /**
     * PublishService constructor.
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->console = array_get($options, 'console');

        $this->path = array_get($options, 'path', __DIR__ . '/updates');

        $this->registerUpdates();
    }

    /**
     * Register updates
     *
     * @codeCoverageIgnore
     */
    public function registerUpdates()
    {
        foreach (app('belt')->packages() as $package) {
            $path = $package['dir'] . '/updates';
            if (file_exists($path)) {
                foreach (scandir($path) as $file) {
                    if (str_contains($file, '.php')) {
                        $name = $this->getUpdateKey($file);
                        $fullpath = "$path/$file";
                        $this->register($name, function ($service, $options = []) use ($fullpath) {
                            $this->runUpdate($fullpath, $options);
                        });
                    }
                }
            }
        }
    }

    /**
     * @param $name
     * @param callable $macro
     */
    public static function register($name, callable $macro)
    {
        static::macro(base64_encode($name), $macro);
    }

    /**
     * @param $params
     */
    public function run($params)
    {
        $name = base64_encode($params[0]);
        if (static::hasMacro($name)) {
            unset($params[0]);
            static::$name($this, $params);
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

        return implode('_', array_slice(explode('_', $stripped_name), 4));
    }

    /**
     * Find corresponding update file and run it
     *
     * @param $key
     * @param $options
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

        $updater->up();
    }

}