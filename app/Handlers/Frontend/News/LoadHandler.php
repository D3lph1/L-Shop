<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\News;

use App\DataTransferObjects\Frontend\Shop\News\Container;
use App\DataTransferObjects\Frontend\Shop\News\Item;
use App\Repository\News\NewsRepository;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;

class LoadHandler
{
    /**
     * @var NewsRepository
     */
    private $newsRepository;

    /**
     * @var Settings
     */
    private $settings;

    public function __construct(NewsRepository $newsRepository, Settings $settings)
    {
        $this->newsRepository = $newsRepository;
        $this->settings = $settings;
    }

    public function load(int $portion): Container
    {
        $paginator = $this->newsRepository->findAllPaginated(
            $this->settings->get('system.news.pagination.per_page')->getValue(DataType::INT), $portion);

        $items = $paginator->items();
        $result = [];
        foreach ($items as $item) {
            $result[] = new Item($item);
        }

        return new Container($result, $paginator->total(), $portion);
    }
}
