<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Users\Edit;

use App\Exceptions\Ban\DoesNotExistException;
use App\Repository\Ban\BanRepository;

class DeleteBanHandler
{
    /**
     * @var BanRepository
     */
    private $banRepository;

    public function __construct(BanRepository $banRepository)
    {
        $this->banRepository = $banRepository;
    }

    public function handle(int $banId): void
    {
        $ban = $this->banRepository->find($banId);
        if ($ban === null) {
            throw new DoesNotExistException($banId);
        }

        $this->banRepository->remove($ban);
    }
}
