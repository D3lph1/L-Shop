<?php
declare(strict_types = 1);

namespace App\Services\Auth\Checkpoint;

use App\Entity\User;

class Pool
{
    /**
     * @var Checkpoint[]
     */
    private $checkpoints = [];

    private $enabledDefault;

    /**
     * @var bool
     */
    private $enabled;

    /**
     * Pool constructor.
     *
     * @param Checkpoint[] $checkpoints
     * @param bool         $enabled
     */
    public function __construct(array $checkpoints = [], bool $enabled = true)
    {
        $this->checkpoints = $checkpoints;
        $this->enabledDefault = $enabled;
        $this->enabled = $enabled;
    }

    public function put(Checkpoint $checkpoint): bool
    {
        foreach ($this->checkpoints as $each) {
            if ($each->getName() === $checkpoint->getName()) {
                return false;
            }
        }
        $this->checkpoints[] = $checkpoint;

        return true;
    }

    public function get(string $name): ?Checkpoint
    {
        foreach ($this->checkpoints as $each) {
            if ($each->getName() === $name) {
                return $each;
            }
        }

        return null;
    }

    public function has(string $name): bool
    {
        foreach ($this->checkpoints as $each) {
            if ($each->getName() === $name) {
                return true;
            }
        }

        return false;
    }

    public function all()
    {
        return $this->checkpoints;
    }

    public function remove(string $name): bool
    {
        foreach ($this->checkpoints as $key => &$each) {
            if ($each->getName() === $name) {
                unset($this->checkpoints[$key]);

                return true;
            }
        }

        return false;
    }

    public function passLogin(User $user): bool
    {
        if ($this->isEnabled()) {
            foreach ($this->all() as $checkpoint) {
                if (!$checkpoint->login($user)) {
                    return false;
                }
            }
        }

        return true;
    }

    public function passCheck(User $user): bool
    {
        if ($this->isEnabled()) {
            foreach ($this->all() as $checkpoint) {
                if (!$checkpoint->check($user)) {
                    return false;
                }
            }
        }

        return true;
    }

    public function passLoginFail(): void
    {
        if ($this->isEnabled()) {
            foreach ($this->all() as $checkpoint) {
                $checkpoint->loginFail();
            }
        }
    }

    public function disable(): void
    {
        $this->enabled = false;
    }

    public function enable(): void
    {
        $this->enabled = true;
    }

    public function reset(): void
    {
        $this->enabled = $this->enabledDefault;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
