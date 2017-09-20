<?php
declare(strict_types = 1);

namespace App\TransactionScripts;

use App\DataTransferObjects\Page;
use App\Exceptions\Page\NotFoundException;
use App\Exceptions\Page\UrlAlreadyExistsException;
use App\Repositories\Page\PageInterface;
use App\Repositories\Page\PageRepositoryInterface;
use Cache;

class Pages
{
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function create(Page $dto): PageInterface
    {
        if (!$this->isUrlUniqueAll($dto->getUrl())) {
            throw new UrlAlreadyExistsException($dto->getUrl());
        }

        return $this->pageRepository->create($dto);
    }

    public function informationForEdit(int $pageId): PageInterface
    {
        $page = $this->pageRepository->find($pageId, ['title', 'content', 'url']);

        if (is_null($page)) {
            throw new NotFoundException($pageId);
        }

        return $page;
    }

    public function informationForList()
    {
        return $this->pageRepository->paginated();
    }

    public function update(Page $dto): bool
    {
        if (!$this->isUrlUnique($dto->getId(), $dto->getUrl())) {
            throw new UrlAlreadyExistsException($dto->getUrl());
        }

        Cache::forget("page.{$dto->getUrl()}");

        return $this->pageRepository->update($dto->getId(), $dto);
    }

    public function delete(int $pageId): bool
    {
        return $this->pageRepository->delete($pageId);
    }

    /**
     * Checks whether the transmitted URL is unique of all records.
     *
     * @param string $url Verifiable URL.
     *
     * @return bool
     */
    private function isUrlUniqueAll(string $url)
    {
        return $this->pageRepository->isUrlUniqueAll($url);
    }

    /**
     * Checks whether the transmitted URL is unique.
     *
     * @param int    $id The identifier of the page being checked. It is necessary to exclude from the scan directly
     *                   the static page itself.
     * @param string $url Verifiable URL.
     *
     * @return bool
     */
    private function isUrlUnique(int $id, string $url)
    {
        return $this->pageRepository->isUrlUnique($id, $url);
    }
}
