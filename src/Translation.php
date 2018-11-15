<?php

namespace Belt\Core;

use Belt;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Translation
 * @package Belt\Core
 */
class Translation extends Model
    implements Belt\Core\Behaviors\IncludesLocaleInterface
{
    use Belt\Core\Behaviors\IncludesLocale;

    /**
     * @var string
     */
    protected $morphClass = 'translations';

    /**
     * @var string
     */
    protected $table = 'translations';

    /**
     * @var array
     */
    protected $fillable = ['locale', 'translatable_column', 'value'];

}