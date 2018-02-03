<?php
declare(strict_types = 1);

namespace Tests\Unit\Services\Settings\Repository;

use App\Services\Settings\Repository\MemoryRepository;
use App\Services\Settings\Setting;
use Tests\TestCase;

class MemoryRepositoryTest extends TestCase
{
    public function test(): void
    {
        $repository = new MemoryRepository();
        self::assertCount(0, $repository->findAll());
        $repository->create(new Setting('key', 'value'));
        $repository->create(new Setting('lorem', 'ipsum'));
        $all = $repository->findAll();
        self::assertCount(2, $all);
        self::assertEquals('key', $all[0]->getKey());
        self::assertEquals('value', $all[0]->getValue());
        self::assertNull($all[0]->getUpdatedAt());
        self::assertEquals('lorem', $all[1]->getKey());
        self::assertEquals('ipsum', $all[1]->getValue());
        self::assertNull($all[1]->getUpdatedAt());

        $repository->delete($all[1]);
        $all = $repository->findAll();
        self::assertCount(1, $all);
        self::assertEquals('key', $all[0]->getKey());
        self::assertEquals('value', $all[0]->getValue());
        self::assertNull($all[0]->getUpdatedAt());

        $all[0]->setValue('new value');
        $repository->update($all[0]);

        $all = $repository->findAll();
        self::assertCount(1, $all);
        self::assertEquals('key', $all[0]->getKey());
        self::assertEquals('new value', $all[0]->getValue());
    }
}
