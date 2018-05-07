<?php

use Illuminate\Database\Seeder;

class BeltCoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BeltCoreAlertSeeds::class);
        $this->call(BeltCoreRoleSeeds::class);
        $this->call(BeltCoreUserSeeds::class);
        $this->call(BeltCoreTeamSeeds::class);
        $this->call(BeltCorePermissibleSeeds::class);
    }
}
