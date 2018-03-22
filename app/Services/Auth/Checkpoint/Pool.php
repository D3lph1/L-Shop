<?php
declare(strict_types = 1);

namespace App\Services\Auth\Checkpoint;

use App\Entity\User;

/**
 * Class Pool
 * The checkpoint pool is the location where all currently active checkpoints are stored.
 */
class Pool
{
    /**
     * @var Checkpoint[]
     */
    private $checkpoints = [];

    /**
     * @var bool
     */
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

    /**
     * Adds checkpoint to the pool.
     *
     * @param Checkpoint $checkpoint
     *
     * @return bool True - successful addition.
     */
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

    /**
     * Retrieve checkpoint from pool by name.
     *
     * @param string $name Checkpoint name.
     *
     * @return Checkpoint|null Null - if checkpoint does not exists.
     */
    public function get(string $name): ?Checkpoint
    {
        foreach ($this->checkpoints as $each) {
            if ($each->getName() === $name) {
                return $each;
            }
        }

        return null;
    }

    /**
     * Checks the checkpoint for existence.
     *
     * @param string $name Checkpoint name.
     *
     * @return bool True - checkpoint exists, false - otherwise.
     */
    public function has(string $name): bool
    {
        foreach ($this->checkpoints as $each) {
            if ($each->getName() === $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * Retrieve all checkpoints from pool.
     *
     * @return Checkpoint[]
     */
    public function all()
    {
        return $this->checkpoints;
    }

    /**
     * Remove checkpoint from pool by name.
     *
     * @param string $name Checkpoint name.
     *
     * @return bool True - checkpoint has been removed. False - checkpoint does not exists.
     */
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

    /**
     * Proceeds through the checkpoints and the login() method.
     *
     * @param User $user User for execution of checkpoints.
     *
     * @return bool True - all checkpoints are passed successfully, false - at least one is not passed.
     */
    public function passLogin(User $user): bool
    {
        // If the pool is empty the pass is considered successful.
        if (count($this->all()) === 0) {
            return true;
        }

        if ($this->isEnabled()) {
            foreach ($this->all() as $checkpoint) {
                if (!$checkpoint->login($user)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Proceeds through the checkpoints and the check() method.
     *
     * @param User $user User for execution of checkpoints.
     *
     * @return bool True - all checkpoints are passed successfully, false - at least one is not passed.
     */
    public function passCheck(User $user): bool
    {
        // If the pool is empty the pass is considered successful.
        if (count($this->all()) === 0) {
            return true;
        }

        if ($this->isEnabled()) {
            foreach ($this->all() as $checkpoint) {
                if (!$checkpoint->check($user)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Proceeds through the checkpoints and the loginFail() method.
     */
    public function passLoginFail(): void
    {
        if ($this->isEnabled()) {
            foreach ($this->all() as $checkpoint) {
                $checkpoint->loginFail();
            }
        }
    }

    /**
     * Disables all checkpoints (pool) This means that they will no longer be executed when the
     * hooks of the life cycle occur.
     */
    public function disable(): void
    {
        $this->enabled = false;
    }

    /**
     * Enables all checkpoints.
     */
    public function enable(): void
    {
        $this->enabled = true;
    }

    /**
     * Sets the default pool activation.
     */
    public function reset(): void
    {
        $this->enabled = $this->enabledDefault;
    }

    /**
     * Checks if the pool is enabled.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
