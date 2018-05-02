<?php
declare(strict_types=1);

use App\Entity\User;
use App\Repository\Activation\ActivationRepository;
use App\Repository\News\NewsRepository;
use App\Repository\Persistence\PersistenceRepository;
use App\Repository\Reminder\ReminderRepository;
use App\Repository\Role\RoleRepository;
use App\Repository\User\UserRepository;
use App\Services\Auth\Activator;
use App\Services\Auth\Auth;
use App\Services\Auth\Roles;
use Illuminate\Database\Seeder;

class TestsSeeder extends Seeder
{
    public function run(
        Auth $auth,
        Activator $activator,
        RoleRepository $roleRepository,
        UserRepository $userRepository,
        ActivationRepository $activationRepository,
        ReminderRepository $reminderRepository,
        PersistenceRepository $persistenceRepository,
        NewsRepository $newsRepository): void
    {
        $this->call(SettingsSeeder::class);
        $this->call(RolesSeeder::class);

        $activationRepository->deleteAll();
        $reminderRepository->deleteAll();
        $persistenceRepository->deleteAll();
        $newsRepository->deleteAll();
        $userRepository->deleteAll();

        $user = $auth->register(new User('admin', 'admin@example.com', 'admin'));
        $activator->activate($user);

        $adminRole = $roleRepository->findByName(Roles::ADMIN);
        $user->addRole($adminRole);
        $adminRole->addUser($user);
        $userRepository->update($user);
        $roleRepository->update($adminRole);
    }
}
