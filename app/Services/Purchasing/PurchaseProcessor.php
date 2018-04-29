<?php
declare(strict_types = 1);

namespace App\Services\Purchasing;

use App\DataTransferObjects\Frontend\Shop\Catalog\Purchase as ResultDTO;
use App\DataTransferObjects\Frontend\Shop\Purchase;
use App\Entity\User;
use App\Events\Purchase\PurchaseCompletedEvent;
use App\Events\Purchase\PurchaseCreatedEvent;
use App\Services\Auth\Auth;
use App\Services\User\Balance\Transactor;
use Illuminate\Contracts\Events\Dispatcher;

class PurchaseProcessor
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var PurchaseCreator
     */
    private $creator;

    /**
     * @var PurchaseCompleter
     */
    private $completer;

    /**
     * @var Transactor
     */
    private $transactor;

    /**
     * @var Dispatcher
     */
    private $eventDispatcher;

    public function __construct(
        Auth $auth,
        PurchaseCreator $creator,
        PurchaseCompleter $completer,
        Transactor $transactor,
        Dispatcher $eventDispatcher)
    {
        $this->auth = $auth;
        $this->creator = $creator;
        $this->completer = $completer;
        $this->transactor = $transactor;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param Purchase[]  $DTOs
     * @param null|string $username
     * @param string      $ip
     *
     * @return ResultDTO
     */
    public function process(array $DTOs, ?string $username, string $ip): ResultDTO
    {
        if ($this->auth->check()) {
            $user = $this->auth->getUser();
        } else {
            // User purchases without authorization.
            $user = $username;
        }
        $purchase = $this->creator->create($DTOs, $user, $ip);
        $this->eventDispatcher->dispatch(new PurchaseCreatedEvent($purchase));

        if ($this->enoughMoney($user, $purchase->getCost())) {
            $this->writeOffMoney($user, $purchase->getCost());
            $this->completer->complete($purchase, ViaContext::QUICK);
            $this->eventDispatcher->dispatch(new PurchaseCompletedEvent($purchase));

            return (new ResultDTO(true))
                ->setNewBalance($purchase->getUser()->getBalance());
        } else {
            return (new ResultDTO(false))
                ->setPurchaseId($purchase->getId());
        }
    }

    private function enoughMoney($user, float $cost): bool
    {
        // If the user is not authorized, he must pay for purchases directly.
        if (!($user instanceof User)) {
            return false;
        }

        return $user->getBalance() - $cost >= 0;
    }

    private function writeOffMoney(User $user, float $cost): void
    {
        $this->transactor->sub($user, $cost);
    }
}
