<?php
declare(strict_types = 1);

namespace App\Models\Payment;

interface PaymentInterface
{
    public function getId(): int;

    public function getService(): string;

    public function getProducts(): array;

    public function getCost(): float;

    public function getUserId(): ?int;

    public function getUsername(): ?string;

    public function getServerId(): int;
}
