<?php
declare(strict_types = 1);

namespace App\Models\Server;

use Carbon\Carbon;

/**
 * Interface ServerInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models\Server
 */
interface ServerInterface
{
    public function getCategories(): iterable;


    public function getId(): int;

    public function getName(): string;

    public function getIp(): ?string ;

    public function getPort(): ?int;

    public function getPassword(): ?string;

    public function isEnabled(): bool;

    public function isMonitoringEnabled(): bool;

    public function getCreatedAt(): Carbon;

    public function getUpdatedAt(): ?Carbon;
}
