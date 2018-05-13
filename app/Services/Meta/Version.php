<?php
declare(strict_types = 1);

namespace App\Services\Meta;

use App\Services\Meta\AdditionalVersion\AdditionalVersion;

/**
 * This class represents the version model. Used for convenient versioning.
 * The version consists of three main and one additional parts.
 * (major version).(minor version).(patch version)[-(alpha number|beta number|release candidate number)]
 *
 * @example "2.1.4": 2 - major version, 1 - minor version, 4 - patch version. Additional version does not exist.
 */
class Version
{
    /**
     * @var int
     */
    private $major;

    /**
     * @var int
     */
    private $minor;

    /**
     * @var int
     */
    private $patch;

    /**
     * @var int|AdditionalVersion
     */
    private $additionalVersion = null;

    public function __construct(int $major, int $minor, int $patch, ?AdditionalVersion $additionalVersion = null)
    {
        $this->major = $major;
        $this->minor = $minor;
        $this->patch = $patch;
        $this->additionalVersion = $additionalVersion;
    }

    public function getMajor(): int
    {
        return $this->major;
    }

    public function getMinor(): int
    {
        return $this->minor;
    }

    public function getPatch(): int
    {
        return $this->patch;
    }

    public function getAdditionalVersion(): ?AdditionalVersion
    {
        return $this->additionalVersion;
    }

    public function hasAdditionalVersion(): bool
    {
        return $this->getAdditionalVersion() !== null;
    }

    public function formatted(): string
    {
        $version = "{$this->getMajor()}.{$this->getMinor()}.{$this->getPatch()}";
        if ($this->hasAdditionalVersion()) {
            $version .= '-' . $this->additionalVersion->formatted();
        }

        return $version;
    }

    public function __toString(): string
    {
        return $this->formatted();
    }
}
