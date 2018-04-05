<?php

namespace Belt\Core\Services\Update;

use Belt;
use Belt\Core\Behaviors\HasConsole;
use Illuminate\Support\Traits\Macroable;

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
    }

    /**
     * Register updates
     *
     * @codeCoverageIgnore
     */
    public function registerUpdates()
    {
        $this->register('templates', function ($service, $options = []) {
            if (belt()->uses('content')) {
                $this->runUpdate('templates.php', $options);
            }
        });

        $this->register('roles', function ($service, $options = []) {
            if (belt()->uses('content')) {
                $this->runUpdate('admin_roles.php', $options);
            }
        });
    }

    /**
     * @param $version
     * @param callable $macro
     */
    public static function register($version, callable $macro)
    {
        static::macro(base64_encode($version), $macro);
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
     * Find corresponding update file and run it
     *
     * @param $key
     * @param $options
     */
    public function runUpdate($key, $options = [])
    {
        foreach (scandir($this->path) as $file) {
            if (str_contains($file, $key)) {
                include sprintf('%s/%s', $this->path, $file);
                $class = 'BeltUpdate' . title_case(str_replace('.php', '', $key));
                $params = [
                    'console' => $this->console,
                    'options' => $options,
                ];
                $updater = new $class($params);
                $updater->up();
            }
        }
    }

}