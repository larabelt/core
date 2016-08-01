<?php

use Illuminate\Database\Seeder;

use Ohio\Core\Role\RoleRepository;

class OhioRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $repository = new RoleRepository(app());
        $repository->create(['name' => 'SUPER']);
        $repository->create(['name' => 'ADMIN']);
        $repository->create(['name' => 'EDITOR']);
    }
}
