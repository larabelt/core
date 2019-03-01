<?php

namespace Tests\Belt\Core\Base;

use Belt\Core\Helpers\BeltHelper;

/**
 * Class RefreshDatabase
 * @package Tests\Belt\Core
 */
trait RefreshDatabase
{
    /**
     * Copy and paste testDB stub over actual testDB
     *
     * Called frequently during testing to quickly reset
     * the databases values. This prevents changes to the testDB
     * during one test affecting the outcome of another test.
     *
     * @codeCoverageIgnore
     */
    public function refreshDB()
    {
        app()['config']->set('database.default', 'sqlite');
        app()['config']->set('database.connections.sqlite.database', 'database/testing/stub.sqlite');

        $disk = BeltHelper::baseDisk();

        $path = 'database/testing';

        # create stub DB for unit testing
        $disk->delete("$path/stub.sqlite");
        $disk->copy("$path/database.sqlite", "$path/stub.sqlite");
    }
}