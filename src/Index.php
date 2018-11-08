<?php

namespace Belt\Core;

use Belt;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Index
 * @package Belt\Core
 */
class Index extends Model
    implements Belt\Core\Behaviors\IncludesLocaleInterface
{
    use Belt\Core\Behaviors\IncludesLocale;

    /**
     * @var string
     */
    protected $morphClass = 'index';

    /**
     * @var string
     */
    protected $table = 'index';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function indexable()
    {
        return $this->morphTo('indexable');
    }

}