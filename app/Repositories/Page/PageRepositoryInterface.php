<?php
declare(strict_types = 1);

namespace App\Repositories\Page;

use App\DataTransferObjects\Page;
use App\Models\Page\PageInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Interface PageRepositoryInterface
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\Page
 */
interface PageRepositoryInterface
{
    public function create(Page $dto): PageInterface;

    public function findByUrl(string $url, array $columns): PageInterface;

    public function getPaginated(array $columns): LengthAwarePaginator;

    public function isUrlUnique(int $pageId, string $url): bool;

    public function isUrlUniqueAll(string $url): bool;
}
