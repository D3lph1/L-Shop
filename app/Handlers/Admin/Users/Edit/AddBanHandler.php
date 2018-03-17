<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Users\Edit;

use App\DataTransferObjects\Admin\Users\Edit\AddBan;
use App\DataTransferObjects\Admin\Users\Edit\Ban as BanDTO;
use App\Entity\Ban;
use App\Exceptions\User\DoesNotExistException;
use App\Repository\Ban\BanRepository;
use App\Repository\User\UserRepository;
use App\Services\Auth\BanManager;

class AddBanHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var BanRepository
     */
    private $banRepository;

    /**
     * @var BanManager
     */
    private $banManager;

    public function __construct(UserRepository $userRepository, BanRepository $banRepository, BanManager $banManager)
    {
        $this->userRepository = $userRepository;
        $this->banRepository = $banRepository;
        $this->banManager = $banManager;
    }

    public function handle(AddBan $dto): BanDTO
    {
        $user = $this->userRepository->find($dto->getUserId());
        if ($user === null) {
            throw new DoesNotExistException($dto->getUserId());
        }

        if ($dto->isForever()) {
            $ban = new Ban($user, null);
        } else {
            $dateTime = new \DateTimeImmutable($dto->getDateTime());

            $ban = new Ban($user, $dateTime);
        }

        $ban->setReason($dto->getReason());
        $this->banRepository->create($ban);

        return new BanDTO($ban, $this->banManager->isExpired($ban));
    }
}
