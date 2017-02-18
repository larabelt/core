<?php

use Illuminate\Database\Seeder;

use Belt\Core\Team;

class BeltCoreTeamSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Team::class, 100)->create()->each(function ($team) {
            //$team->posts()->save(factory(App\Post::class)->make());
        });
    }
}
