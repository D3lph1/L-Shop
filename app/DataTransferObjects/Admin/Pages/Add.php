<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Pages;

class Add
{
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
     * @param string $title
     *
     * @return Add
     */
    public function setTitle(string $title): Add
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $content
     *
     * @return Add
     */
    public function setContent(string $content): Add
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $url
     *
     * @return Add
     */
    public function setUrl(string $url): Add
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}
