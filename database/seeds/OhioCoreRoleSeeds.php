<?php

use Illuminate\Database\Seeder;

use Ohio\Core\Role;

class OhioCoreRoleSeeds extends Seeder
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
