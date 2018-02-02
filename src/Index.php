<?php

namespace Belt\Core;

use Belt;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Index
 * @package Belt\Core
 */
class Index extends Model
{

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