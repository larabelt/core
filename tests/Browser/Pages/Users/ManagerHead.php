<?php

namespace Tests\Belt\Core\Browser\Pages\Users;

use Laravel\Dusk\Component as BaseComponent;

class ManagerHead extends BaseComponent
{
    protected $selector;

    public function __construct($selector = '')
    {
        $this->selector = $selector;
    }

    /**
     * Get the root selector for the component.
     *
     * @return string
     */
    public function selector()
    {
        return $this->selector;
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@id' => 'th:nth-child(1)',
            '@id-sort' => 'th:nth-child(1) a',
            '@email' => 'th:nth-child(2)',
            '@email-sort' => 'th:nth-child(2) a',
            '@first-name' => 'th:nth-child(3)',
            '@first-name-sort' => 'th:nth-child(3) a',
            '@last-name' => 'th:nth-child(4)',
            '@last-name sort' => 'th:nth-child(4) a',
            '@created' => 'th:nth-child(5)',
            '@created-sort' => 'th:nth-child(5) a',
            '@updated' => 'th:nth-child(6)',
            '@updated-sort' => 'th:nth-child(6) a',
            '@actions' => 'th:nth-child(7)',
        ];
    }
}
