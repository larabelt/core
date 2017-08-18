<?php

use Illuminate\Database\Seeder;

use Belt\Core\Team;
use Belt\Core\User;

class BeltCoreTeamSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Team::unguard();
        User::unguard();

        // awesome team
        $team = Team::firstOrCreate(['name' => 'Awesome']);
        $team->update(['is_active' => true]);

        // awesome user
        $user = User::firstOrCreate([
            'first_name' => 'CAPTAIN',
            'last_name' => 'AWESOME',
            'email' => 'awesome@larabelt.org',
        ]);
        $user->update([
            'is_super' => false,
            'first_name' => 'CAPTAIN',
            'last_name' => 'AWESOME',
            'password' => bcrypt('secret')
        ]);

        factory(Team::class, 100)->create()->each(function ($team) {
            //$team->posts()->save(factory(App\Post::class)->make());
        });

        // add user to teams
        $user->teams()->attach($team);
        $user->teams()->attach(5);
        $user->teams()->attach(10);
    }
}
