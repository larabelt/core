<?php

use Illuminate\Database\Seeder;

use Ohio\Core\Team\Team;
use Ohio\Core\User\User;
use Ohio\Core\TeamUser\TeamUser;

class OhioCoreTeamSeeds extends Seeder
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
