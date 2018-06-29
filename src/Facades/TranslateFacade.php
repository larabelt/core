<?php

namespace Belt\Core\Facades;

use Belt\Core\Services\TranslateService;
use Illuminate\Support\Facades\Facade;

/**
 * Class TranslateFacade
 * @package Belt\Core
 */
class TranslateFacade extends Facade
{
    /**
     * @see TranslateService
     */
    protected static function getFacadeAccessor(): string
    {
        return 'translate';
    }
}
