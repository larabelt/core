<?php

use Illuminate\Database\Seeder;

use Belt\Core\User;

class BeltCoreUserSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::unguard();

        $superUser = User::firstOrCreate([
            'first_name' => 'SUPER',
            'last_name' => 'ADMIN',
            'email' => 'super@larabelt.org',
        ]);

        $superUser->update([
            'is_super' => true,
            'first_name' => 'SUPER',
            'last_name' => 'ADMIN',
            'password' => bcrypt('secret')
        ]);

        factory(User::class, 50)->create()->each(function ($user) {
            //$user->posts()->save(factory(App\Post::class)->make());
        });
    }
}
