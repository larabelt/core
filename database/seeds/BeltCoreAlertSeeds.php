<?php

use Illuminate\Database\Seeder;

use Belt\Core\Alert;

class BeltCoreAlertSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Alert::class, 1)->create([
            'is_active' => true,
            'starts_at' => strtotime('-1 day'),
            'ends_at' => strtotime('+100 days'),
        ]);
        factory(Alert::class, 5)->create(['is_active' => false]);
    }
}
