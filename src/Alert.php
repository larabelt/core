<?php

namespace Belt\Core;

use Belt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Alert
 * @package Belt\Core
 */
class Alert extends Model implements
    Belt\Core\Behaviors\SluggableInterface
{

    use Belt\Core\Behaviors\Sluggable;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $morphClass = 'alerts';

    /**
     * @var string
     */
    protected $table = 'alerts';

    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @var array
     */
    protected $dates = ['starts_at', 'ends_at', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * Default values
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => 1,
    ];

    /**
     * @param $value
     */
    public function setIsActiveAttribute($value)
    {
        $this->attributes['is_active'] = boolval($value);
    }

    /**
     * @param $value
     * @return null
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper(trim($value));
    }

    /**
     * @param $query
     * @param $datetime
     */
    public function scopeActive($query, $datetime = null)
    {

        $datetime = $datetime ?: date('Y-m-d H:i:s', strtotime('now'));

        $query->where('alerts.is_active', true);
        $query->where(function ($query) use ($datetime) {
            $query->whereNull('alerts.starts_at');
            $query->orWhere('alerts.starts_at', '<=', $datetime);
        });
        $query->where(function ($query) use ($datetime) {
            $query->whereNull('alerts.ends_at');
            $query->orWhere('alerts.ends_at', '>=', $datetime);
        });
    }


}