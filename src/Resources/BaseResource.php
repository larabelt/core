<?php

namespace Belt\Core\Resources;

use Belt, Illuminate;

/**
 * Class BaseBuilder
 * @package Belt\Content\Builders
 */
abstract class BaseResource
    implements Illuminate\Contracts\Support\Arrayable
{
    use Belt\Core\Resources\Traits\HasDescription,
        Belt\Core\Resources\Traits\HasLabel;

    /**
     * @var string
     */
    protected $key;

    /**
     * BaseResource constructor.
     * @param array $options
     */
    public function __construct($options = [])
    {
        if ($key = array_get($options, 'key')) {
            $this->setKey($key);
        }

        $this->setup();
    }

    /**
     * @return BaseResource
     */
    static function make($key = null)
    {
        return new static([
            'key' => $key,
        ]);
    }

    public function setup()
    {

    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param $key
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return mixed
     */
    public function toArray()
    {
        return [];
    }
}