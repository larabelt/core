<?php

namespace Belt\Core\Behaviors;

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

        $this->console->warn($string, $verbosity);
    }
}