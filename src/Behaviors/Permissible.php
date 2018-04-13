<?php namespace Belt\Core\Behaviors;

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
     * Determine if the entity has a given ability.
     *
     * @todo re-write when upgrading to laravel 5.5
     * @param  string $ability
     * @param  array|mixed $arguments
     * @return bool
     */
    public function can($abilities, $arguments = [])
    {
        foreach ((array) $abilities as $ability) {
            if (parent::can($ability, $arguments)) {
                return true;
            }
        }

        return false;
    }

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