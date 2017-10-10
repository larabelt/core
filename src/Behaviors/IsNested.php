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

        $ancestors = $this->ancestors()->get();

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
     * @param string $glue
     * @return string
     */
    public function getNestedName($glue = ' > ')
    {
        $names = $this->getAncestors()->pluck('name')->all();

        $names[] = $this->name;

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