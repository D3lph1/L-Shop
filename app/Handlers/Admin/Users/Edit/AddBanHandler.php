<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Users\Edit;

use App\DataTransferObjects\Admin\Users\Edit\AddBan;
use App\DataTransferObjects\Admin\Users\Edit\Ban as BanDTO;
use App\Entity\Ban;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\UnexpectedValueException;
use App\Exceptions\User\DoesNotExistException;
use App\Repository\Ban\BanRepository;
use App\Repository\User\UserRepository;
use App\Services\Auth\BanManager;

class AddBanHandler
{
    public const MODE_CONCRETE = 'concrete';

    public const MODE_DAYS = 'days';

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
            $ban = $this->banManager->banPermanently($user, $dto->getReason());
        } else {
            if ($dto->getMode() === self::MODE_CONCRETE) {
                if (empty($dto->getDateTime())) {
                    throw new InvalidArgumentException('DateTime can not be empty');
                }

                $dateTime = new \DateTimeImmutable($dto->getDateTime());

                $ban = $this->banManager->banUntil($user, $dateTime, $dto->getReason());
            } else if ($dto->getMode() === self::MODE_DAYS) {
                $ban = $this->banManager->banForDays($user, $dto->getDays(), $dto->getReason());
            } else {
                throw new UnexpectedValueException("Mode value `{$dto->getMode()}` is invalid");
            }
        }

        return new BanDTO($ban, $this->banManager->isExpired($ban));
    }
}
