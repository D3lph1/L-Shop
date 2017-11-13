<?php
declare(strict_types = 1);

namespace App\Contracts;

/**
 * Interface UUIDable
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Contracts
 */
interface UUIDable
{
    /**
     * @return string|null Universally Unique Identifier.
     *
     * @see https://en.wikipedia.org/wiki/UUID
     */
    public function getUUID(): ?string;
}
