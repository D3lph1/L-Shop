<?php
declare(strict_types = 1);

namespace App\Repositories\Persistence;

use App\Models\Persistence\EloquentPersistence;
use Cartalyst\Sentinel\Persistences\IlluminatePersistenceRepository;

class EloquentPersistenceRepository extends IlluminatePersistenceRepository implements PersistenceRepositoryInterface
{
    public function truncate(): void
    {
        EloquentPersistence::truncate();
    }
}
