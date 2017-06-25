<?php

namespace App\Services;

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

    public function all()
    {
        return $this->pageRepository->getPaginated();
    }

    /**
     * Create new static page.
     *
     * @param string $title   Static page title.
     * @param string $content Static page content.
     * @param string $url     Static page url.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($title, $content, $url)
    {
        return $this->pageRepository->create([
            'title' => $title,
            'content' => $content,
            'url' => $url
        ]);
    }

    /**
     * @param int   $id         Updated static page identifier.
     * @param array $attributes New static page attributes.
     *
     * @return bool
     */
    public function update($id, array $attributes)
    {
        \Cache::forget("page.{$attributes['url']}");

        return $this->pageRepository->update($id, $attributes);
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
