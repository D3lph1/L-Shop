<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Items\Add;

use Symfony\Component\Finder\SplFileInfo;

class Image implements \JsonSerializable
{
    /**
     * @var SplFileInfo
     */
    private $file;

    public function __construct(SplFileInfo $file)
    {
        $this->file = $file;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->file->getFilename(),
            'url' => \App\Services\Item\Image\Image::assetPathOrDefault($this->file->getFilename())
        ];
    }
}
