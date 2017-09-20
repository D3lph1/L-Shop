<?php
declare(strict_types = 1);

namespace App\Repositories\Ban;

use App\DataTransferObjects\Ban;
use App\Models\Ban\BanInterface;
use App\Repositories\BaseRepositoryInterface;
use Cartalyst\Sentinel\Users\UserInterface;

/**
 * Interface BanRepositoryInterface
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\Ban
 */
interface BanRepositoryInterface extends BaseRepositoryInterface
{
    public function create(Ban $dto): BanInterface;

    public function findByUser(UserInterface $user): ?BanInterface;

    public function deleteByUser(UserInterface $user): bool;

    public function isBanned(UserInterface $user): bool;
}
