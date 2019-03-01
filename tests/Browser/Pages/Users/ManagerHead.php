<?php

namespace Tests\Belt\Core\Browser\Pages\Users;

use Tests\Belt\Core\Browser\Pages\Base\BaseManager;
use Laravel\Dusk\Browser;
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
            '@first-name' => 'th:nth-child(3)',
            '@last-name' => 'th:nth-child(4)',
            '@created' => 'th:nth-child(5)',
            '@updated' => 'th:nth-child(6)',
            '@actions' => 'th:nth-child(7)',
        ];
    }
}
