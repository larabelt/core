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
        Role\Role::firstOrCreate(['name' => 'SUPER']);
        Role\Role::firstOrCreate(['name' => 'ADMIN']);
        Role\Role::firstOrCreate(['name' => 'EDITOR']);
    }
}
