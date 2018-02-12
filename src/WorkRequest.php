<?php

namespace Belt\Core;

use Belt;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkRequest
 * @package Belt\Core
 */
class WorkRequest extends Model
{
    /**
     * @var string
     */
    protected $table = 'work_requests';

    /**
     * @var array
     */
    protected $fillable = ['workable_id', 'workable_type', 'workflow_class'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'payload' => 'json',
    ];

    /**
     * @var array
     */
    protected $appends = ['workflow'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function workable()
    {
        return $this->morphTo('workable');
    }

    /**
     * @return mixed
     */
    public function getWorkflowAttribute()
    {
        return (new $this->workflow_class($this->workable))->toArray();
    }

}