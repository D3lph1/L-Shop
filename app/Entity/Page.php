<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages")
 */
class Page
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=false, unique=false)
     */
    private $title;

    /**
     * @ORM\Column(name="content", type="text", nullable=false, unique=false)
     */
    private $content;

    /**
     * @ORM\Column(name="url", type="string", length=255, nullable=false, unique=true)
     */
    private $url;

    public function __construct(string $title, string $content, string $url)
    {
        $this->setTitle($title);
        $this->setContent($content);
        $this->setUrl($url);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Page
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): Page
    {
        $this->content = $content;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): Page
    {
        $this->url = $url;

        return $this;
    }
}
