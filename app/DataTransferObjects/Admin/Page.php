<?php

namespace App\DataTransferObjects\Admin;

/**
 * Class Page
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\DataTransferObjects\Admin
 */
class Page
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $url;

    /**
     * Page constructor.
     *
     * @param string $title
     * @param string $content
     * @param string $url
     */
    public function __construct(string $title, string $content, string $url)
    {
        $this->title = $title;
        $this->content = $content;
        $this->url = $url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
