<?php

namespace Belt\Core\Http\Controllers\Behaviors;

use Belt;

trait Content
{

    /**
     * @param $slug
     * @return null|Belt\Content\Page
     */
    public function contentPage($slug)
    {
        $page = null;
        if (belt()->uses('content')) {
            $page = Belt\Content\Page::query()
                ->where('is_active', true)
                ->sluggish($slug)
                ->first();
        }

        return $page;
    }

}