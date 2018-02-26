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
        $this->register('1.2.15', function () {
            if (belt()->uses('content')) {
                $this->runUpdate('templates1.php');
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
     * @param $version
     */
    public function run($version)
    {
        $name = base64_encode($version);
        if (static::hasMacro($name)) {
            static::$name($this);
        }
    }


    /**
     * Find corresponding update file and run it
     *
     * @param $key
     */
    public function runUpdate($key)
    {
        foreach (scandir($this->path) as $file) {
            if (str_contains($file, $key)) {
                include sprintf('%s/%s', $this->path, $file);
                $class = 'BeltUpdate' . title_case(str_replace('.php', '', $key));
                $updater = new $class(['console' => $this->console]);
                $updater->up();
            }
        }
    }

}