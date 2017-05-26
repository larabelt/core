<?php

namespace Belt\Core\Http\Controllers;

use Belt\Core\Helpers\MorphHelper;
use Illuminate\Database\Eloquent\Model;

trait Morphable
{
    /**
     * @var MorphHelper
     */
    public $morphHelper;

    /**
     * @return MorphHelper
     */
    public function morphHelper()
    {
        return $this->morphHelper ?: $this->morphHelper = new MorphHelper();
    }

    /**
     * @param string $type
     * @param integer $id
     * @return Model
     */
    public function morphable($type, $id)
    {
        $morphable = $this->morphHelper()->morph($type, $id);

        return $morphable ?: $this->abort(404);
    }

}