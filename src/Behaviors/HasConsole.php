<?php

namespace Belt\Core\Behaviors;

use Belt\Core\Helpers\DebugHelper;
use Illuminate\Console\Command;

/**
 * Class HasConsole
 * @package Belt\Core\Behaviors
 */
trait HasConsole
{
    /**
     * @var Command
     */
    public $console;

    /**
     * @param $string
     * @param null $verbosity
     */
    public function info($string, $verbosity = null)
    {
        if (!$this->console) {
            return;
        }

        $string = DebugHelper::buffer($string);

        $this->console->info($string, $verbosity);
    }

    /**
     * @param $string
     * @param null $verbosity
     */
    public function warn($string, $verbosity = null)
    {
        if (!$this->console) {
            return;
        }

        $string = DebugHelper::buffer($string);

        $this->console->warn($string, $verbosity);
    }
}