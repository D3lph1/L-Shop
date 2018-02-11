<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Shop\News;

use Illuminate\Support\Str;

class Item implements \JsonSerializable
{
    /**
     * @var \App\Entity\News
     */
    private $news;

    public function __construct(\App\Entity\News $news)
    {
        $this->news = $news;
    }

    public function getNews(): \App\Entity\News
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
            'content' => Str::limit($this->getNews()->getContent(), 150, '...'),
            'url' => route('frontend.news.render', ['id' => $this->getNews()->getId()])
        ];
    }
}
