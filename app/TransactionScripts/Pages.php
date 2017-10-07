<?php
declare(strict_types = 1);

namespace App\TransactionScripts;

use App\DataTransferObjects\Page;
use App\Exceptions\Page\NotFoundException;
use App\Exceptions\Page\UrlAlreadyExistsException;
use App\Models\Page\PageInterface;
use App\Repositories\Page\PageRepositoryInterface;
use App\Traits\ContainerTrait;
use Cache;

/**
 * Class Pages
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\TransactionScripts
 */
class Pages
{
    use ContainerTrait;

    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function get(string $url): PageInterface
    {
        $page = $this->pageRepository->findByUrl($url, ['title', 'content']);

        if (is_null($page)) {
            throw new NotFoundException($url);
        }

        return $page;
    }

    public function create(PageInterface $entity): PageInterface
    {
        if (!$this->isUrlUniqueAll($entity->getUrl())) {
            throw new UrlAlreadyExistsException($entity->getUrl());
        }

        return $this->pageRepository->create($entity);
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

        /** @var PageInterface $entity */
        $entity = $this->make(PageInterface::class);
        $entity
            ->setTitle($dto->getTitle())
            ->setContent($dto->getContent())
            ->setUrl($dto->getUrl());

        return $this->pageRepository->update($dto->getId(), $entity);
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
