<?php

use Belt\Core\User;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade;

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

        # super user
        $user = User::firstOrCreate(['email' => 'super@larabelt.org']);
        $user->update([
            'is_super' => true,
            'first_name' => 'SUPER',
            'last_name' => 'ADMIN',
            'password' => bcrypt('secret')
        ]);
        BouncerFacade::assign('super')->to($user);

        # admin user
        $user = User::firstOrCreate(['email' => 'admin@larabelt.org']);
        $user->update([
            'first_name' => 'JOE',
            'last_name' => 'ADMIN',
            'password' => bcrypt('secret')
        ]);
        BouncerFacade::assign('admin')->to($user);

        # editor user
        $user = User::firstOrCreate(['email' => 'editor@larabelt.org']);
        $user->update([
            'first_name' => 'JIMMY',
            'last_name' => 'OLSEN',
            'password' => bcrypt('secret')
        ]);
        BouncerFacade::assign('editor')->to($user);

        # regular user
        $user = User::firstOrCreate(['email' => 'user@larabelt.org']);
        $user->update([
            'first_name' => 'REGULAR',
            'last_name' => 'USER',
            'password' => bcrypt('secret')
        ]);

        factory(User::class, 20)->create()->each(function ($user) {
            //$user->posts()->save(factory(App\Post::class)->make());
        });
    }
}
