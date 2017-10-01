<?php
declare(strict_types = 1);

namespace App\Repositories\Cart;

use App\DataTransferObjects\Cart;
use App\Models\Cart\CartInterface;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Interface CartRepositoryInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\Cart
 */
interface CartRepositoryInterface extends BaseRepositoryInterface
{
    public function create(Cart $dto): CartInterface;

    public function insert(array $attributes): bool;

    public function historyForUser($userLogin, int $server, array $columns): LengthAwarePaginator;

    public function getByPlayerWithItems(string $player, array $cartColumns, array $itemColumns): iterable;

    public function all(): iterable;
}
