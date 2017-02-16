<?php

use Illuminate\Database\Seeder;

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
        Role::firstOrCreate(['name' => 'ADMIN']);
        Role::firstOrCreate(['name' => 'EDITOR']);
    }
}
