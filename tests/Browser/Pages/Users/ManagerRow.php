<?php

namespace Tests\Belt\Core\Browser\Pages\Users;

use Tests\Belt\Core\Browser\Pages\Base\BaseManager;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class ManagerRow extends BaseComponent
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
            '@id' => 'td:nth-child(1)',
            '@email' => 'td:nth-child(2)',
            '@first-name' => 'td:nth-child(3)',
            '@last-name' => 'td:nth-child(4)',
            '@created' => 'td:nth-child(5)',
            '@updated' => 'td:nth-child(6)',
            '@actions' => 'td:nth-child(7)',
        ];
    }
}
