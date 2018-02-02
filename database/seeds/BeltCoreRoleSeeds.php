<?php

use Illuminate\Database\Seeder;

use Silber\Bouncer\BouncerFacade;
use Belt\Core\Ability;
use Belt\Core\Role;

class BeltCoreRoleSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(['name' => 'super']);
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'editor']);
    }
}
