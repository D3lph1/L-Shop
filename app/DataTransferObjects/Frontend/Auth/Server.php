<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Auth;

class Server implements \JsonSerializable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var string
     */
    private $url;

    public function __construct(string $name, bool $enabled, string $url)
    {
        $this->name = $name;
        $this->enabled = $enabled;
        $this->url = $url;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'enabled' => $this->isEnabled(),
            'url' => $this->getUrl()
        ];
    }
}
