<?php

namespace App\Services;

use App\DataTransferObjects\Page as DTO;
use App\Exceptions\Page\UrlAlreadyExistsException;
use App\Repositories\PageRepository;

/**
 * Class Page
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class Page
{
    /**
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * @param PageRepository $pageRepository
     */
    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        return $this->pageRepository->getPaginated(['id', 'title', 'url', 'created_at', 'updated_at']);
    }

    /**
     * Create new static page.
     *
     * @param DTO $page
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(DTO $page)
    {
        if ($this->isUrlUniqueAll($page->getUrl())) {
            return $this->pageRepository->create([
                'title' => $page->getTitle(),
                'content' => $page->getContent(),
                'url' => $page->getUrl()
            ]);
        }

        throw new UrlAlreadyExistsException($page->getUrl());
    }

    /**
     * Update static page.
     *
     * @param DTO $page
     *
     * @return bool
     */
    public function update(DTO $page)
    {
        if ($this->isUrlUnique($page->getId(), $page->getUrl())) {
            \Cache::forget("page.{$page->getUrl()}");

            return $this->pageRepository->update($page->getId(), [
                'title' => $page->getTitle(),
                'content' => $page->getContent(),
                'url' => $page->getUrl(),
            ]);
        }

        throw new UrlAlreadyExistsException($page->getUrl());
    }

    /**
     * Delete static page by identifier.
     *
     * @param string $id Static page identifier.
     *
     * @return bool|null
     */
    public function delete($id)
    {
        return $this->pageRepository->delete($id);
    }

    /**
     * Checks whether the transmitted URL is unique of all records.
     *
     * @param string $url Verifiable URL.
     *
     * @return bool
     */
    public function isUrlUniqueAll($url)
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
    public function isUrlUnique($id, $url)
    {
        return $this->pageRepository->isUrlUnique($id, $url);
    }

    /**
     * Get static page by identifier.
     *
     * @param int   $id Static page identifier.
     * @param array $columns Columns for sampling.
     *
     * @return mixed
     */
    public function getById($id, $columns = [])
    {
        return $this->pageRepository->find($id, $columns);
    }

    /**
     * Get static page by URL.
     *
     * @param string $url Static page URL.
     * @param array  $columns Columns for sampling.
     *
     * @return bool|\App\Models\Page
     */
    public function getByUrl($url, $columns = [])
    {
        $result = $this->pageRepository->findByUrl($url, $columns);

        return isset($result[0]) ? $result[0] : false;
    }
}
