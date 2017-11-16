<?php

namespace Belt\Core\Http\Controllers\Behaviors;

use Belt, Illuminate;

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
            $page = $this->contentQuery()
                ->where('is_active', true)
                ->sluggish($slug)
                ->first();
        }

        return $page;
    }

    /**
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function contentQuery()
    {
        return Belt\Content\Page::query();
    }

}