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
     * @var array
     */
    public $arguments = [];

    /**
     * @var array
     */
    public $argumentMap = [];

    /**
     * @var array
     */
    public $options = [];

    /**
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->console = array_get($params, 'console');

        foreach (array_get($params, 'options', []) as $key => $value) {
            if (str_contains($value, '=')) {
                $option = explode('=', $value);
                $this->options[trim($option[0])] = trim($option[1]);
            } else {
                $this->arguments[] = $value;
            }

        }
    }

    abstract public function up();

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function option($key, $default = null)
    {
        return array_get($this->options, $key, $default);
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function argument($key, $default = null)
    {
        $position = array_search($key, $this->argumentMap);
        if ($position !== false) {
            return $this->arguments[$position] ?? $default;
        }

        return $default;
    }

}