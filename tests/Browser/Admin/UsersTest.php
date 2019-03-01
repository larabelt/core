<?php

namespace Tests\Belt\Core\Browser\Admin;

use Belt\Core\User;
use Tests\Belt\Core\Browser\Pages;
use Tests\Belt\Core\DuskTestCase;
use Laravel\Dusk\Browser;

class UsersTest extends DuskTestCase
{

    /**
     * A basic browser test example.
     *
     * @throws \Throwable
     */
    public function testManager()
    {
        // manager
        // -- ManagerRow elements
        // verify sorting...
        // verify filter
        // table row counts?

        // manager sorting
        // manager filters
        // creator
        // editor
        // editor tabs...

        $this->browse(function (Browser $browser) {

            $browser->loginAs(User::find(1))->visit(new Pages\Users\Manager);

            $browser->whenAvailable('@row1', function (Browser $row) {
                $row->within(new Pages\Users\ManagerRow, function (Browser $cells) {
                    $cells->assertSeeIn('@id', 1);
                    $cells->assertSeeIn('@email', 'super@larabelt.org');
                });
            });

            $browser->whenAvailable('@row2', function (Browser $row) {
                $row->within(new Pages\Users\ManagerRow, function (Browser $cells) {
                    $cells->assertSeeIn('@id', 2);
                    $cells->assertSeeIn('@email', 'admin@larabelt.org');
                });
            });

            $browser->whenAvailable('@head', function (Browser $head) {
                $head->within(new Pages\Users\ManagerHead, function (Browser $cells) {
                    $cells->click('@id-sort');
                });
            });

            $browser->waitUntilMissing('@spinner');

            $browser->within('@row1', function (Browser $row) {
                $row->within(new Pages\Users\ManagerRow, function (Browser $cells) {
                    $user = User::orderBy('id', 'desc')->first();
                    $cells->assertSeeIn('@id', $user->id);
                });
            });

        });

    }

}