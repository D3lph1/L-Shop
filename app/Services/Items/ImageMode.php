<?php
declare(strict_types = 1);

namespace App\Services\Items;

/**
 * Class ImageType
 * Defines the available image setting types for an item.
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\Items
 */
final class ImageMode
{
    /**
     * Leaves the current image.
     */
    public const CURRENT = 'current';

    /**
     * Set the default image.
     */
    public const DEFAULT = 'default';

    /**
     * Set the uploaded image.
     */
    public const UPLOAD = 'upload';

    private function __construct()
    {
        //
    }
}
