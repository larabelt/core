<?php

namespace Belt\Core\Services\Update;

use Belt;
use Belt\Core\Behaviors\HasConsole;
use Belt\Core\Behaviors\HasDisk;

/**
 * Class BaseUpdate
 * @package Belt\Core\Services\Update
 */
abstract class BaseUpdate
{
    use HasConsole;
    use HasDisk;

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

    /**
     * @param $old_path
     * @param $new_path
     * @codeCoverageIgnore
     */
    public function rename($old_path, $new_path)
    {
        if (file_exists($old_path)) {
            rename($old_path, $new_path);
            $this->info("rename old path: $old_path");
            $this->info("rename new path: $new_path");
        }
    }

    /**
     * @param $path
     * @param array $replacements
     * @param bool $recursive
     * @codeCoverageIgnore
     */
    public function replace($path, $replacements = [], $recursive = false)
    {
        $files = $this->disk()->files($path, $recursive);

        foreach ($files as $file) {
            $contents = $new_contents = $this->disk()->get($file);
            foreach ($replacements as $search => $replace) {
                $new_contents = str_replace($search, $replace, $new_contents);
            }
            if ($new_contents != $contents) {
                $this->info("updating file: $file");
                $this->disk()->put($file, $new_contents);
            }
        }
    }

}