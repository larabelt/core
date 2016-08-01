<?php

use Illuminate\Database\Seeder;

use Ohio\Core\User\User;
use Ohio\Core\User\UserRepository;
use Ohio\Core\Role\RoleRepository;
use Ohio\Core\UserRole\UserRoleRepository;

class OhioUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRepository = new UserRepository(app());
        $roleRepository = new RoleRepository(app());
        $userRoleRepository = new UserRoleRepository(app());

        $superUser = $userRepository->create([
            'first_name' => 'SUPER',
            'last_name' => 'ADMIN',
            'email' => 'super@ohiocms.org',
            'password' => bcrypt('secret'),
        ]);

        $admin_role = $roleRepository->findByField('name', 'SUPER')->first();

        $userRoleRepository->create([
            'user_id' => $superUser->id,
            'role_id' => $admin_role->id,
        ]);

        factory(User::class, 10)->create()->each(function ($user) {
            //$user->posts()->save(factory(App\Post::class)->make());
        });
    }
}
