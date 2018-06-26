<?php

namespace Belt\Core\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;
use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;

/**
 * Class EncryptCookies
 * @package Belt\Core\Http\Middleware
 */
class EncryptCookies extends BaseEncrypter
{

    protected static $also_except = [];

    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        'adminlte',
        'guid',
    ];

    /**
     * EncryptCookies constructor.
     * @param EncrypterContract $encrypter
     */
    public function __construct(EncrypterContract $encrypter)
    {
        $this->except = array_merge($this->except, static::$also_except);

        parent::__construct($encrypter);
    }

    /**
     * @param $key
     */
    public static function except($key)
    {
        if (!in_array($key, static::$also_except)) {
            static::$also_except[] = $key;
        }
    }

}