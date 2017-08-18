<?php namespace Belt\Core\Behaviors;

use Belt\Core\Team;

/**
 * Class Teamable
 * @package Belt\Core\Behaviors
 */
trait Teamable
{

    /**
     * @return mixed
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

}