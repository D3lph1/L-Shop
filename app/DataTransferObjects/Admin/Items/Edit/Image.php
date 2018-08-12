<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Items\Edit;

use Symfony\Component\Finder\SplFileInfo;

class Image
{
    /**
     * @var SplFileInfo
     */
    private $file;

    /**
     * @var bool
     */
    private $isCurrent;

    public function __construct(SplFileInfo $file, bool $isCurrent)
    {
        $this->file = $file;
        $this->isCurrent = $isCurrent;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->file->getFilename(),
            'url' => \App\Services\Item\Image\Image::assetPathOrDefault($this->file->getFilename()),
            'current' => $this->isCurrent
        ];
    }
}
