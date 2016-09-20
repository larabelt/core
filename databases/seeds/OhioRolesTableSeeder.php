<?php

use Illuminate\Database\Seeder;

use Ohio\Core\Role;

class OhioRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role\Role::create(['name' => 'SUPER']);
        Role\Role::create(['name' => 'ADMIN']);
        Role\Role::create(['name' => 'EDITOR']);
    }
}
