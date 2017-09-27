<?php

namespace Belt\Core\Services\Update;

use Belt;
use Belt\Core\Behaviors\HasConsole;

/**
 * Class UpdateService
 * @package Belt\Core\Services
 */
class UpdateService
{
    use HasConsole;

    /**
     * @var string
     */
    public $version;

    /**
     * @var array
     */
    public $directory;

    /**
     * PublishService constructor.
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->console = array_get($options, 'console');
        $this->version = array_get($options, 'version', Belt\Core\BeltCoreServiceProvider::VERSION);
        $this->directory = scandir(__DIR__ . '/updates');
    }

    /**
     * Run update by version
     */
    public function update()
    {
        switch ($this->version) {
            case '1.2.15':
                if (belt()->uses('content')) {
                    $this->__update('templates1.php');
                }
                break;
        }
    }

    /**
     * Find corresponding update file and run it
     *
     * @param $key
     */
    public function __update($key)
    {
        foreach ($this->directory as $file) {
            if (str_contains($file, $key)) {
                include __DIR__ . '/updates/' . $file;
                $class = 'BeltUpdate' . title_case(str_replace('.php', '', $key));
                $updater = new $class(['console' => $this->console]);
                $updater->up();
            }
        }
    }

}