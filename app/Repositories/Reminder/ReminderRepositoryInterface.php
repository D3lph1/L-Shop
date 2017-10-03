<?php
declare(strict_types = 1);

namespace App\Repositories\Reminder;

use App\Repositories\BaseRepositoryInterface;

/**
 * Interface ReminderRepositoryInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\Reminder
 */
interface ReminderRepositoryInterface extends BaseRepositoryInterface
{
    public function deleteByUser(int $userId): bool;
}
