<?php

namespace Belt\Core\Behaviors;

use GuzzleHttp;

/**
 * Class HasGuzzle
 * @package Belt\Core\Behaviors
 */
trait HasGuzzle
{
    /**
     * @var GuzzleHttp\Client
     */
    public $guzzle;

    /**
     * @return GuzzleHttp\Client
     */
    public function guzzle()
    {
        return $this->guzzle ?: $this->guzzle = new GuzzleHttp\Client();
    }
}