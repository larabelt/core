<?php

use Illuminate\Database\Seeder;

class OhioCoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(OhioCoreRoleSeeds::class);
        $this->call(OhioCoreUserSeeds::class);
        $this->call(OhioCoreTeamSeeds::class);
    }
}
