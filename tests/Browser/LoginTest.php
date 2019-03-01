<?php

namespace Tests\Belt\Core\Browser;

use Tests\Belt\Core\Browser\Pages;
use Tests\Belt\Core\DuskTestCase;
use Laravel\Dusk\Browser;

class LoginTest extends DuskTestCase
{

    /**
     * A basic browser test example.
     *
     * @throws \Throwable
     */
    public function testSuperLogin()
    {
        $this->browse(function (Browser $browser) {

            # when unauthenticated user visits protected url
            # they are redirected to login page
            $browser->visit('/admin/belt/core/users')
                ->assertPathIs('/login');

            # when user submits invalid login credentials
            # they are redirected to login page
            $browser->on(new Pages\Login)
                ->type('@email', 'super@larabelt.org')
                ->type('@password', 'invalid')
                ->press('@login')
                ->assertPathIs('/login');

            # when user submits valid login credentials
            # they are redirected to the originally attempted url
            $browser->on(new Pages\Login)
                ->type('@email', 'super@larabelt.org')
                ->type('@password', 'secret')
                ->press('@login')
                ->assertPathIs('/admin/belt/core/users');

            # when authenticated user visits the login page
            # they are redirected to generic admin dashboard
            $browser->visit(new Pages\Login)
                ->assertPathIs('/admin');
        });
    }

}