<?php

namespace App\Services;

use App\Repositories\PageRepository;

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

    public function create($title, $content, $url)
    {
        return $this->pageRepository->create([
            'title' => $title,
            'content' => $content,
            'url' => $url
        ]);
    }
}
