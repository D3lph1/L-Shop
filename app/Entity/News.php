<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Represents a news.
 *
 * @ORM\Entity
 * @ORM\Table(name="news")
 * @ORM\HasLifecycleCallbacks
 */
class News
{
    /**
     * Unique news identifier.
     *
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
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @ORM\Column(name="created_at", type="datetime_immutable", nullable=false)
     */
    private $createdAt;

    /**
     * News constructor.
     *
     * @param string $title
     * @param string $content
     * @param User   $user
     */
    public function __construct(string $title, string $content, User $user)
    {
        $this->title = $title;
        $this->content = $content;
        $this->user = $user;
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
     * @return News
     */
    public function setTitle(string $title): News
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
     * @return News
     */
    public function setContent(string $content): News
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return News
     */
    public function setUser(User $user): News
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function generateCreatedAt(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * Creates string representation of object.
     * <p>For example:</p>
     * <p>App\Entity\News(id=7, title="Example title")</p>
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
