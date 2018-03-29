<?php
declare(strict_types = 1);

namespace App\Services\User\Balance;

use App\Entity\BalanceTransaction;
use App\Entity\User;
use App\Exceptions\InvalidArgumentException;
use App\Repository\BalanceTransaction\BalanceTransactionRepository;
use App\Repository\User\UserRepository;

/**
 * Class Transactor
 * The class performs add/sub/set of the user's balance with the logging of transaction information.
 */
class Transactor
{
    /**
     * @var BalanceTransactionRepository
     */
    private $transactionRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var User
     */
    private $user;

    public function __construct(BalanceTransactionRepository $repository, UserRepository $userRepository, User $user)
    {
        $this->transactionRepository = $repository;
        $this->userRepository = $userRepository;
        $this->user = $user;
    }

    /**
     * @param float $value
     *
     * @return float New balance.
     */
    public function add(float $value): float
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('The argument $value must be a positive number');
        }

        $this->transactionRepository->create(new BalanceTransaction($value, $this->user));
        $this->user->setBalance($this->user->getBalance() + $value);
        $this->userRepository->update($this->user);

        return $this->user->getBalance();
    }

    /**
     * @param float $value
     *
     * @return float New balance.
     */
    public function sub(float $value): float
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('The argument $value must be a positive number');
        }

        // When debiting money from the balance, the delta must be negative number.
        $this->transactionRepository->create(new BalanceTransaction($value * -1, $this->user));
        $this->user->setBalance($this->user->getBalance() - $value);
        $this->userRepository->update($this->user);

        return $this->user->getBalance();
    }

    public function set(float $value): void
    {
        if ($value < 0) {
            throw new InvalidArgumentException('The argument $value must be a equals or greater than 0');
        }

        $this->transactionRepository->create(new BalanceTransaction($value - $this->user->getBalance(), $this->user));
        $this->user->setBalance($value);
        $this->userRepository->update($this->user);
    }
}
