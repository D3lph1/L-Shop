<?php
declare(strict_types=1);

use App\Entity\User;
use App\Repository\Activation\ActivationRepository;
use App\Repository\BalanceTransaction\BalanceTransactionRepository;
use App\Repository\Ban\BanRepository;
use App\Repository\Distribution\DistributionRepository;
use App\Repository\News\NewsRepository;
use App\Repository\Persistence\PersistenceRepository;
use App\Repository\Purchase\PurchaseRepository;
use App\Repository\Reminder\ReminderRepository;
use App\Repository\Role\RoleRepository;
use App\Repository\User\UserRepository;
use App\Services\Auth\Auth;
use App\Services\Auth\Roles;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(
        Auth $auth,
        RoleRepository $roleRepository,
        UserRepository $userRepository,
        BanRepository $banRepository,
        ActivationRepository $activationRepository,
        ReminderRepository $reminderRepository,
        PersistenceRepository $persistenceRepository,
        NewsRepository $newsRepository,
        BalanceTransactionRepository $balanceTransactionRepository,
        PurchaseRepository $purchaseRepository,
        DistributionRepository $distributionRepository): void
    {
        $activationRepository->deleteAll();
        $reminderRepository->deleteAll();
        $persistenceRepository->deleteAll();
        $newsRepository->deleteAll();
        $banRepository->deleteAll();
        $balanceTransactionRepository->deleteAll();
        $distributionRepository->deleteAll();
        $purchaseRepository->deleteAll();
        $userRepository->deleteAll();

        $user = $auth->register(new User('admin', 'admin@example.com', 'admin'), true);

        $adminRole = $roleRepository->findByName(Roles::ADMIN);
        $user->addRole($adminRole);
        $adminRole->addUser($user);
        $userRepository->update($user);
        $roleRepository->update($adminRole);

        $user = $auth->register(new User('user', 'user@example.com', '123456'), true);
        $userRole = $roleRepository->findByName(Roles::USER);
        $user->addRole($userRole);
        $userRole->addUser($user);
        $userRepository->update($user);
        $roleRepository->update($userRole);
    }
}
