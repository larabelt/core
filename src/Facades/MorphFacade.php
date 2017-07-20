<?php

namespace Belt\Core\Facades;

use Belt\Core\Helpers\MorphHelper;
use Illuminate\Support\Facades\Facade;

/**
 * Class MorphFacade
 * @package Belt\Core
 */
class MorphFacade extends Facade
{
    /**
     * @see MorphHelper
     */
    protected static function getFacadeAccessor(): string
    {
        return 'morph';
    }
}
