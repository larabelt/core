<?php

namespace Belt\Core\Services\Update;

use Belt;
use Belt\Core\Behaviors\HasConsole;

/**
 * Class BaseUpdate
 * @package Belt\Core\Services\Update
 */
abstract class BaseUpdate
{
    use HasConsole;

    /**
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->console = array_get($options, 'console');
    }

    abstract public function up();

}