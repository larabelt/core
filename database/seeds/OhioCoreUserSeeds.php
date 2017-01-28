<?php

use Illuminate\Database\Seeder;

use Ohio\Core\User;
use Ohio\Core\Role;

class OhioCoreUserSeeds extends Seeder
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
            'email' => 'super@ohiocms.org',
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
