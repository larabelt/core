<?php namespace Belt\Core\Behaviors;

use Kalnoy\Nestedset\NodeTrait;

/**
 * Class IsNested
 * @package Belt\Core\Behaviors
 */
trait IsNested
{

    use NodeTrait;

    /**
     * @return array
     */
    public function getHierarchyAttribute()
    {
        $hierarchy = [];

        $ancestors = $this->getAncestors();

        if ($ancestors->count()) {
            foreach ($ancestors as $ancestor) {
                $hierarchy[] = [
                    'id' => $ancestor->id,
                    'name' => $ancestor->name,
                    'slug' => $ancestor->slug,
                ];
            }
        }

        $hierarchy[] = [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
        ];

        return $hierarchy;
    }

    /**
     * @return array
     */
    public function getNestedNames()
    {
        $names = $this->getAncestors()->pluck('name')->all();
        $names[] = $this->name;

        return $names;
    }

    /**
     * @return array
     */
    public function getNestedSlugs()
    {
        $slugs = $this->getAncestors()->pluck('slug')->all();
        $slugs[] = $this->slug;

        return $slugs;
    }

    /**
     * @param string $glue
     * @return string
     */
    public function getNestedName($glue = ' > ')
    {
        $names = $this->getNestedNames();

        return implode($glue, $names);
    }

    /**
     * @return string
     */
    public function getNestedNameAttribute()
    {
        return $this->getNestedName();
    }

}