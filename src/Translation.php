<?php

namespace Belt\Core;

use Belt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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

    /**
     * The Associated owning model
     *
     * @return MorphTo|Model
     */
    public function translatable()
    {
        return $this->morphTo();
    }

}