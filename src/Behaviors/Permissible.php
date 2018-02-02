<?php namespace Belt\Core\Behaviors;

use Cache;
use Silber\Bouncer\Database\HasRolesAndAbilities;

/**
 * Class Permissible
 * @package Belt\Core\Behaviors
 */
trait Permissible
{
    use HasRolesAndAbilities;

    /**
     * @var null|boolean
     */
    private $super;

    /**
     * @param $value
     */
    public function setSuper($value)
    {
        $this->super = (boolean) $value;
    }

    /**
     * @return mixed
     */
    public function super()
    {
        if (!is_null($this->super)) {
            return $this->super;
        }

        $super = $this->getAttribute('is_super') ? true : false;

        if (!$super) {
            $super = $this->getAbilities()
                ->where('entity_type', '*')
                ->where('name', '*')
                ->first() ? true : false;
        }

        $this->setSuper($super);

        return $this->super;
    }

    /**
     * @return bool|null
     */
    public function getSuperAttribute()
    {
        return $this->super();
    }

}