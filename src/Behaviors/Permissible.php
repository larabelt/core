<?php namespace Belt\Core\Behaviors;

use Morph;
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

            if (is_string($arguments) && !class_exists($arguments)) {
                $arguments = Morph::type2Class($arguments);
            }

            if ($this->parentCan($ability, $arguments)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @todo get rid of this
     * @codeCoverageIgnore
     * @param $ability
     * @param array $arguments
     * @return bool
     */
    public function parentCan($ability, $arguments = [])
    {
        return parent::can($ability, $arguments);
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