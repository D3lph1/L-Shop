<?php
declare(strict_types = 1);

use Cartalyst\Sentinel\Sentinel;
use Illuminate\Database\Seeder;

/**
 * Class UsersSeeder
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 */
class UsersSeeder extends Seeder
{
    /**
     * @var Sentinel
     */
    private $sentinel;

    public function __construct(Sentinel $sentinel)
    {
        $this->sentinel = $sentinel;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createAdmin();
        $this->createUser();
    }

    private function createAdmin(): void
    {
        $user = $this->sentinel->registerAndActivate([
            'id' => 1,
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'admin',
            'balance' => 1000,
        ]);

        $role = $this->sentinel->getRoleRepository()->createModel()->create([
            'id' => 1,
            'slug' => 'admin',
            'name' => __('seeding.roles.admin'),
            'permissions' => [
                'user.admin' => true
            ]
        ]);

        $this->sentinel->getRoleRepository()->attachUser($role->getId(), $user->getId());
    }

    private function createUser(): void
    {
        $user = $this->sentinel->registerAndActivate([
            'id' => 2,
            'username' => 'user',
            'email' => 'user@example.com',
            'password' => 'user',
            'balance' => 0,
        ]);

        $role = $this->sentinel->getRoleRepository()->createModel()->create([
            'id' => 2,
            'slug' => 'user',
            'name' => __('seeding.roles.user'),
            'permissions' => [
                'user.admin' => false
            ]
        ]);

        $this->sentinel->getRoleRepository()->attachUser($role->getId(), $user->getId());
    }
}
