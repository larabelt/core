<?php

namespace Tests\Belt\Core\Browser\Pages\Users;

use Tests\Belt\Core\Browser\Pages\Base\BaseManager;
use Laravel\Dusk\Browser;

class Manager extends BaseManager
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/admin/belt/core/users?page=1&orderBy=users.id';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser $browser
     * @return void
     */
    public function assert(Browser $browser)
    {

    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@spinner' => '#belt-users-manager i.fa.fa-spinner.fa-spin',
            '@head' => '#belt-users-manager table thead tr:nth-child(1)',
            '@row1' => '#belt-users-manager table tbody tr:nth-child(1)',
            '@row2' => '#belt-users-manager table tbody tr:nth-child(2)',
        ];
    }
}
