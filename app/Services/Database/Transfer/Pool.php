<?php
declare(strict_types = 1);

namespace App\Services\Database\Transfer;

class Pool
{
    /**
     * @var array
     */
    private $transformers;

    public function __construct(array $transformers = [])
    {
        $this->transformers = $transformers;
    }

    public function put(string $version, Transfer $transformer): bool
    {
        foreach ($this->transformers as $v => $each) {
            if ($v === $version) {
                return false;
            }
        }
        $this->transformers[$version] = $transformer;

        return true;
    }

    public function get(string $version): ?Transfer
    {
        return $this->transformers[$version];
    }

    public function has(string $version): bool
    {
        foreach ($this->transformers as $v => $transformer) {
            if ($v === $version) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return string[]
     */
    public function versions(): array
    {
        return array_keys($this->transformers);
    }
}
