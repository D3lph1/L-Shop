<?php
declare(strict_types = 1);

namespace App\Repositories\Persistence;

use App\Models\Persistence\EloquentPersistence;
use Cartalyst\Sentinel\Persistences\IlluminatePersistenceRepository;

/**
 * Class EloquentPersistenceRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\Persistence
 */
class EloquentPersistenceRepository extends IlluminatePersistenceRepository implements PersistenceRepositoryInterface
{
    public function deleteByUser(int $userId): bool
    {
        return (bool)EloquentPersistence::where('user_id', $userId)->delete();
    }

    public function truncate(): void
    {
        EloquentPersistence::truncate();
    }
}
