<?php

namespace Belt\Core\Commands\Behaviors;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Class ProcessTrait
 * @package Belt\Core\Commands\Behaviors
 */
trait ProcessTrait
{

    /**
     * @param $cmd
     * @return string
     */
    public function process($cmd)
    {
        $process = new Process($cmd);

        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

}