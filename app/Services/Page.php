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
     * Create new static page
     *
     * @param string $title
     * @param string $content
     * @param string $url
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
     * @param int   $id
     * @param array $attributes
     *
     * @return bool
     */
    public function update($id, array $attributes)
    {
        \Cache::forget("page.{$attributes['url']}");

        return $this->pageRepository->update($id, $attributes);
    }

    /**
     * Delete static page by id
     *
     * @param string $id
     *
     * @return bool|null
     */
    public function delete($id)
    {
        return $this->pageRepository->delete($id);
    }

    /**
     * @param int    $id
     * @param string $url
     *
     * @return bool
     */
    public function isUrlUnique($id, $url)
    {
        return $this->pageRepository->isUrlUnique($id, $url);
    }

    /**
     * Get static page by id
     *
     * @param int   $id
     * @param array $columns
     *
     * @return mixed
     */
    public function getById($id, $columns = [])
    {
        return $this->pageRepository->find($id, $columns);
    }

    /**
     * Get static page by url
     *
     * @param string $url
     * @param array  $columns
     *
     * @return bool|\App\Models\Page
     */
    public function getByUrl($url, $columns = [])
    {
        $result = $this->pageRepository->findByUrl($url, $columns);

        return isset($result[0]) ? $result[0] : false;
    }
}
