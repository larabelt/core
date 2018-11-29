<?php namespace Belt\Core\Http\Middleware;

use Belt;
use Belt\Core\Behaviors\HasService;

/**
 * Class SetLocale
 * @package Belt\Core\Http\Middleware
 */
abstract class BaseLocaleMiddleware
{
    use HasService;

    protected $serviceClass = Belt\Core\Services\TranslateService::class;

}