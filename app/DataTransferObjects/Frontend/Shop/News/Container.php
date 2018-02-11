<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Shop\News;

class Container implements \JsonSerializable
{
    /**
     * @var Item[]
     */
    private $newsItems;

    /**
     * @var int
     */
    private $total;

    /**
     * @var int
     */
    private $portion;

    public function __construct(array $newsItems, int $total, int $portion)
    {
        $this->newsItems = $newsItems;
        $this->total = $total;
        $this->portion = $portion;
    }

    /**
     * @return Item[]
     */
    public function getNewsItems(): array
    {
        return $this->newsItems;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getPortion(): int
    {
        return $this->portion;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return [
            'portion' => $this->getPortion(),
            'total' => $this->getTotal(),
            'news' => $this->getNewsItems()
        ];
    }
}
