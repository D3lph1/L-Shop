<?php
declare(strict_types=1);

namespace App\Services\Settings;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="settings")
 * @ORM\HasLifecycleCallbacks
 */
class Setting
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="`key`", type="string", length=255, unique=true, nullable=false)
     */
    private $key;

    /**
     * @ORM\Column(name="value", type="text", unique=false, nullable=true)
     */
    private $value;

    /**
     * @ORM\Column(name="updated_at", type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    public function __construct(string $key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param null $castTo
     *
     * @return mixed
     */
    public function getValue($castTo = null)
    {
        switch ($castTo) {
            case DataType::BOOL:
                return (bool)$this->value;
            case DataType::INT:
                return (int)$this->value;
            case DataType::FLOAT:
                return (float)$this->value;
            case DataType::JSON:
                return json_decode($this->value);
            default:
                return $this->value;
        }
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PreUpdate
     */
    public function generateUpdatedAt(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
