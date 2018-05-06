<?php
declare(strict_types=1);

namespace App\Services\Caching;

interface CachingRepository
{
    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @param string                                     $key
     * @param mixed                                      $value
     * @param \DateTimeInterface|\DateInterval|float|int $ttl
     *
     * @return bool
     */
    public function add(string $key, $value, $ttl = null): bool;

    /**
     * @param string                                     $key
     * @param mixed                                      $value
     * @param \DateTimeInterface|\DateInterval|float|int $ttl
     *
     * @return mixed
     */
    public function set(string $key, $value, $ttl = null): bool;

    /**
     * @param string $key
     *
     * @return bool
     */
    public function delete(string $key): bool;
}
