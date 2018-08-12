<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Represents a static page. Static pages are used to store rarely changing content.
 *
 * @ORM\Entity
 * @ORM\Table(name="pages", indexes={@ORM\Index(name="url_idx", columns={"url"})})
 */
class Page
{
    /**
     * Static page identifier.
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Title of static page.
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false, unique=false)
     */
    private $title;

    /**
     * Main content of static page.
     *
     * @ORM\Column(name="content", type="text", nullable=false, unique=false)
     */
    private $content;

    /**
     * Url (or rather, part of it) for which a static page will be available.
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false, unique=true)
     */
    private $url;

    public function __construct(string $title, string $content, string $url)
    {
        $this->title = $title;
        $this->content = $content;
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Page
     */
    public function setTitle(string $title): Page
    {
        $this->title = $title;

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
     * @param string $content
     *
     * @return Page
     */
    public function setContent(string $content): Page
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return Page
     */
    public function setUrl(string $url): Page
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Creates string representation of object.
     * <p>For example:</p>
     * <p>App\Entity\Page(id=7, title="Example title")</p>
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
            '%s(id=%d, title="%s")',
            self::class,
            $this->getId(),
            $this->getTitle()
        );
    }
}
