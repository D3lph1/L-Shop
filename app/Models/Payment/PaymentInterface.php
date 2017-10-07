<?php
declare(strict_types = 1);

namespace App\Models\Payment;

use App\Models\User\UserInterface;
use Carbon\Carbon;

/**
 * Interface PaymentInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models\Payment
 */
interface PaymentInterface
{
    public function getUser(): UserInterface;


    public function getId(): int;

    public function setService(string $serviceName): PaymentInterface;

    public function getService(): ?string;

    public function setProducts($products): PaymentInterface;

    public function getProducts(): ?array;

    public function getProductsAsString(): ?string;

    public function setCost(float $cost): PaymentInterface;

    public function getCost(): float;

    public function setUserId(?int $userId): PaymentInterface;

    public function getUserId(): ?int;

    public function setUsername(?string $username): PaymentInterface;

    public function getUsername(): ?string;

    public function setServerId(int $server_id): PaymentInterface;

    public function getServerId(): int;

    public function setIp(string $ip): PaymentInterface;

    public function getIp(): string;

    public function setCompleted(bool $isCompleted): PaymentInterface;

    public function isCompleted(): bool;

    public function getCreatedAt(): Carbon;

    public function getUpdatedAt(): ?Carbon;
}
