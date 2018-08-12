<?php
declare(strict_types = 1);

namespace App\Services\Database\Transaction;

interface Transactor
{
    public function begin(): void;

    public function commit(): void;

    public function rollback(): void;
}
