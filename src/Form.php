<?php

namespace Belt\Core;

use Belt;
use Illuminate;

/**
 * Class Form
 * @package TN\Cms\Model
 */
class Form extends Illuminate\Database\Eloquent\Model
{

    use Belt\Core\Behaviors\HasConfig;

    /**
     * @var string database table used by the model
     */
    protected $table = 'forms';

    /**
     * @var array
     */
    protected $fillable = ['config_key'];

    /**
     * @var array
     */
    protected $attributes = [
        'data' => '',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'json',
    ];

    /**
     * @return string
     */
    public function configPath()
    {
        return 'belt.forms.' . $this->config_key;
    }

    /**
     * Convert the model to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->token;
    }

    /**
     * @return mixed
     */
    public function template()
    {
        $class = $this->config('template');

        return new $class($this);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function data($key)
    {
        if ($key && isset($this->data)) {
            return array_get((array) $this->data, $key);
        }
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        return parent::__get($key) ?: $this->data($key);
    }

}