<?php
declare(strict_types = 1);

namespace App\Services\Infrastructure\Meta;

use Illuminate\Contracts\Support\Arrayable;

class Developer implements Arrayable, \JsonSerializable
{
    /**
     * @var string
     */
    private $nickname;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var array
     */
    private $contacts;

    /**
     * @var string|null
     */
    private $avatar;

    public function __construct(
        string $nickname,
        string $name,
        string $description = null,
        array $contacts = [],
        ?string $avatar = null)
    {
        $this->nickname = $nickname;
        $this->name = $name;
        $this->description = $description;
        $this->contacts = $contacts;
        $this->avatar = $avatar;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getContacts(): array
    {
        return $this->contacts;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'nickname' => $this->getNickname(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'contacts' => $this->getContacts(),
            'avatar' => $this->getAvatar()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
