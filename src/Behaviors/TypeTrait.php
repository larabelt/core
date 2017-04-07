<?php
namespace Belt\Core\Behaviors;

trait TypeTrait
{
    public function getTypeAttribute()
    {
        return $this->getTable();
    }
}