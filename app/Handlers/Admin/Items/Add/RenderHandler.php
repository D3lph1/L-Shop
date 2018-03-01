<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Items\Add;

use App\DataTransferObjects\Admin\Items\Add\Image;
use App\DataTransferObjects\Admin\Items\Add\Result;

class RenderHandler
{
    public function handle(): Result
    {
        $images = [];
        foreach (\File::allFiles(\App\Services\Item\Image\Image::absolutePath()) as $item) {
            $images[] = new Image($item);
        }

        return new Result($images);
    }
}
