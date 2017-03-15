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
        factory(Alert::class, 5)->create()->each(function ($alert) {

        });
    }
}
