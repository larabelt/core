<?php

use Illuminate\Database\Seeder;

use Ohio\Core\Model\User\Domain\User;
use Ohio\Core\Model\User\Domain\UserRepository;
use Ohio\Core\Model\Role\Domain\RoleRepository;
use Ohio\Core\Model\UserRole\Domain\UserRoleRepository;

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

        $admin_role = $roleRepository->findByField('name', 'SUPER');

        $userRoleRepository->create([
            'user_id' => $superUser['data']['id'],
            'role_id' => $admin_role['data'][0]['id'],
        ]);

        factory(User::class, 10)->create()->each(function ($user) {
            //$user->posts()->save(factory(App\Post::class)->make());
        });
    }
}
