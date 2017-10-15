<?php
declare(strict_types = 1);

namespace App\Models\Activation;

use Carbon\Carbon;
use Cartalyst\Sentinel\Activations\ActivationInterface as BaseActivationInterface;

/**
 * Interface ActivationInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models\Activation
 */
interface ActivationInterface extends BaseActivationInterface
{
    public function getId(): int;

    public function setUserId(int $userId): ActivationInterface;

    public function getUserId(): int;

    public function setCode(string $code): ActivationInterface;

    public function getCode(): string;

    public function setCompleted(bool $isCompleted): ActivationInterface;

    public function isCompleted(): bool;

    public function getCompletedAt(): ?Carbon;

    public function getCreatedAt(): Carbon;

    public function getUpdatedAt(): ?Carbon;
}
