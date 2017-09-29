<?php
declare(strict_types = 1);

namespace App\TransactionScripts;

use App\DataTransferObjects\Admin\User\Edited;
use App\DataTransferObjects\Admin\User\Listed;
use App\Exceptions\User\AlreadyActivatedException;
use App\Exceptions\User\AttemptToBanYourselfException;
use App\Exceptions\User\AttemptToDeleteYourselfException;
use App\Exceptions\User\EmailAlreadyExistsException;
use App\Exceptions\User\NotFoundException;
use App\Exceptions\User\UsernameAlreadyExistsException;
use App\Models\User\UserInterface;
use App\Repositories\Activation\ActivationRepositoryInterface;
use App\Models\Ban\BanInterface;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Ban;
use App\Services\User\InitStrategies\AdminInitStrategy;
use App\Services\User\InitStrategies\CommonUserInitStrategy;
use App\Services\User\InitStrategies\InitStrategyInterface;
use App\Traits\ContainerTrait;
use Cartalyst\Sentinel\Hashing\HasherInterface;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Users
{
    use ContainerTrait;

    /**
     * @var Sentinel
     */
    private $sentinel;

    public function __construct(Sentinel $sentinel)
    {
        $this->sentinel = $sentinel;
    }

    public function informationForEdit(int $userId): Listed
    {
        /** @var UserInterface $user */
        $user = $this->sentinel->getUserRepository()->findById($userId);
        if (is_null($user)) {
            throw new NotFoundException($userId);
        }
        /** @var CartRepositoryInterface $cartRepository */
        $cartRepository = $this->make(CartRepositoryInterface::class);
        $cartContent = $cartRepository->getByPlayerWithItems(
            $user->getUsername(),
            ['amount', 'server'],
            ['name', 'image']
        );

        return new Listed($user, $cartContent);
    }

    public function informationForList(): LengthAwarePaginator
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $this->sentinel->getUserRepository();
        $users = $userRepository->withRolesActivationsBanPaginated(
            ['username', 'email', 'balance'],
            ['permissions'],
            ['completed', 'completed_at'],
            ['until', 'reason']
        );

        return $users;
    }

    public function edit(Edited $dto)
    {
        /** @var UserInterface $user */
        $user = $this->sentinel->getUserRepository()->findById($dto->getId());
        if (is_null($user)) {
            throw new NotFoundException($dto->getId());
        }

        $credentials = [
            'username' => $dto->getUsername(),
            'email' => $dto->getEmail(),
            'update' => $dto->getPassword(),
            'balance' => $dto->getBalance()
        ];

        /** @var UserInterface $other */
        $other = $this->sentinel->getUserRepository()->findByCredentials(['username' => $dto->getUsername()]);
        if ($other and $other->getId() !== $dto->getId()) {
            throw new UsernameAlreadyExistsException($dto->getUsername());
        }

        /** @var UserInterface $other */
        $other = $this->sentinel->getUserRepository()->findByCredentials(['email' => $dto->getEmail()]);
        if ($other and $other->getId() !== $dto->getId()) {
            throw new EmailAlreadyExistsException($dto->getEmail());
        }

        if (!is_null($dto->getPassword())) {
            /** @var HasherInterface $hasher */
            $hasher = $this->make(HasherInterface::class);
            $credentials['password'] = $hasher->hash($dto->getPassword());
        }

        if ($this->sentinel->getUserRepository()->update($user, $credentials)) {
            if ($dto->isAdmin()) {
                /** @var InitStrategyInterface $strategy */
                $strategy = $this->make(AdminInitStrategy::class);
            } else {
                /** @var InitStrategyInterface $strategy */
                $strategy = $this->make(CommonUserInitStrategy::class);
            }
            $strategy->init($user);

            return true;
        } else {
            return false;
        }
    }

    public function delete(int $userId): bool
    {
        /** @var UserInterface $user */
        $user = $this->sentinel->getUserRepository()->findById($userId);

        if (is_null($user)) {
            throw new NotFoundException($userId);
        }

        if ($userId === $this->sentinel->getUser()->getId()) {
            throw new AttemptToDeleteYourselfException();
        }

        // TODO: refactor it!
        $user->delete();

        return true;
    }

    public function destroySessions(int $userId): bool
    {
        $user = $this->sentinel->getUserRepository()->findById($userId);

        if (is_null($user)) {
            throw new NotFoundException($userId);
        }

        return $this->sentinel->logout($user, true);
    }

    public function block(int $userId, int $duration, ?string $reason): BanInterface
    {
        /** @var UserInterface $user */
        $user = $this->sentinel->getUserRepository()->findById($userId);

        if (is_null($user)) {
            throw new NotFoundException($userId);
        }

        if ($userId === $this->sentinel->getUser()->getId()) {
            throw new AttemptToBanYourselfException();
        }

        /** @var Ban $ban */
        $ban = $this->make(Ban::class);

        if ($duration === 0) {
            return $ban->permanently($user, $reason);
        }

        return $ban->forDays($user, $duration, $reason);
    }

    public function pardon(int $userId): bool
    {
        /** @var UserInterface $user */
        $user = $this->sentinel->getUserRepository()->findById($userId);

        if (is_null($user)) {
            throw new NotFoundException($userId);
        }

        /** @var Ban $ban */
        $ban = $this->make(Ban::class);

        if ($ban->pardon($user)) {
            return true;
        }

        return false;
    }

    public function activate(int $userId): bool
    {
        /** @var $userRepository $repository */
        $userRepository = $this->sentinel->getUserRepository();
        $user = $userRepository->findById($userId);

        if (is_null($user)) {
            throw new NotFoundException($userId);
        }

        /** @var ActivationRepositoryInterface $activationRepository */
        $activationRepository = $this->sentinel->getActivationRepository();

        if ($activationRepository->completed($user)) {
            throw new AlreadyActivatedException($userId);
        }

        return $this->sentinel->activate($user);
    }

    public function search(string $query): iterable
    {
        /** @var UserRepositoryInterface $repository */
        $repository = $this->sentinel->getUserRepository();

        return $repository->search($query, ['>', '<', '=', '>=', '<=', '!=', '<>']);
    }
}
