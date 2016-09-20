<?php

use Illuminate\Database\Seeder;

use Ohio\Core\User\User;
use Ohio\Core\Role\Role;
use Ohio\Core\UserRole\UserRole;

class OhioUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superUser = User::create([
            'first_name' => 'SUPER',
            'last_name' => 'ADMIN',
            'email' => 'super@ohiocms.org',
            'password' => bcrypt('secret'),
        ]);

        $admin_role = Role::whereName('SUPER')->first();

        UserRole::create([
            'user_id' => $superUser->id,
            'role_id' => $admin_role->id,
        ]);

        factory(User::class, 100)->create()->each(function ($user) {
            //$user->posts()->save(factory(App\Post::class)->make());
        });
    }
}
