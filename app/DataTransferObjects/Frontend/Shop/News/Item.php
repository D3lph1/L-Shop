<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Shop\News;

use App\Entity\News;
use App\Services\DateTime\Formatting\JavaScriptFormatter;
use Illuminate\Support\Str;

/**
 * Class Item
 * This is used to serialize a news item to store it in the news list on the client.
 */
class Item implements \JsonSerializable
{
    /**
     * @var News
     */
    private $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function getNews(): News
    {
        return $this->news;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getNews()->getId(),
            'title' => $this->getNews()->getTitle(),
            // Remove all html tags from the string and then trim the string to 150 characters.
            'content' => Str::limit(strip_tags($this->getNews()->getContent()), 150, '...'),
            'createdAt' => (new JavaScriptFormatter())->format($this->getNews()->getCreatedAt())
        ];
    }
}
