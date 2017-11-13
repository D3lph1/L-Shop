<?php
declare(strict_types = 1);

namespace App\Models\Server;

use App\Models\Category\CategoryInterface;
use Carbon\Carbon;

/**
 * Interface ServerInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models\Server
 */
interface ServerInterface
{
    /**
     * @return CategoryInterface[]
     */
    public function getCategories(): iterable;


    public function setId(int $id): ServerInterface;

    public function getId(): ?int;

    public function setName(string $name): ServerInterface;

    public function getName(): string;

    public function setIp(?string $ip): ServerInterface;

    public function getIp(): ?string ;

    public function setPort(?int $port): ServerInterface;

    public function getPort(): ?int;

    public function setPassword(?string $password): ServerInterface;

    public function getPassword(): ?string;

    public function setEnabled(bool $isEnabled): ServerInterface;

    public function isEnabled(): bool;

    public function setMonitoringEnabled(bool $isMonitoringEnabled): ServerInterface;

    public function isMonitoringEnabled(): bool;

    public function getCreatedAt(): Carbon;

    public function getUpdatedAt(): ?Carbon;
}
