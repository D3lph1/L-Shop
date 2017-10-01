<?php
declare(strict_types = 1);

namespace App\Services\Items;

/**
 * Class ImageType
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\Items
 */
final class ImageMode
{
    public const CURRENT = 'current';

    public const DEFAULT = 'default';

    public const UPLOAD = 'upload';

    private function __construct()
    {
        //
    }
}
