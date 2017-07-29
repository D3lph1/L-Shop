<?php

use App\Repositories\CategoryRepository;
use App\Repositories\ServerRepository;
use Illuminate\Database\Seeder;

class ServersSeeder extends Seeder
{
    /**
     * @var ServerRepository
     */
    private $serverRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * ServersSeeder constructor.
     *
     * @param ServerRepository   $serverRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(ServerRepository $serverRepository, CategoryRepository $categoryRepository)
    {
        $this->serverRepository = $serverRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createMmoServer();
        $this->createHiTechPvPServer();
        $this->createHiTechPvEServer();
    }

    private function createMmoServer()
    {
        /** @var \App\Models\Server $server */
        $server = $this->serverRepository->create([
            'id' => 1,
            'name' => 'MMO',
            'enabled' => true,
            'ip' => '127.0.0.1',
            'port' => '25575',
            'password' => '123456',
            'monitoring_enabled' => false,
        ]);

        $this->categoryRepository->create([
            'id' => 1,
            'name' => __('seeding.categories.1'),
            'server_id' => $server->id
        ]);
        $this->categoryRepository->create([
            'id' => 2,
            'name' => __('seeding.categories.2'),
            'server_id' => $server->id
        ]);
        $this->categoryRepository->create([
            'id' => 5,
            'name' => __('seeding.categories.5'),
            'server_id' => $server->id
        ]);
    }

    private function createHiTechPvPServer()
    {
        /** @var \App\Models\Server $server */
        $server = $this->serverRepository->create([
            'id' => 2,
            'name' => 'Hi-Tech (PvP)',
            'enabled' => true,
            'ip' => '127.0.0.1',
            'port' => '25564',
            'password' => '123456',
            'monitoring_enabled' => false,
        ]);

        $this->categoryRepository->create([
            'id' => 3,
            'name' => __('seeding.categories.3'),
            'server_id' => $server->id,
        ]);
    }

    private function createHiTechPvEServer()
    {
        /** @var \App\Models\Server $server */
        $server = $this->serverRepository->create([
            'id' => 3,
            'name' => 'Hi-Tech (PvE)',
            'enabled' => true,
            'ip' => null,
            'port' => null,
            'password' => null,
            'monitoring_enabled' => false,
        ]);

        $this->categoryRepository->create([
            'id' => 4,
            'name' => __('seeding.categories.4'),
            'server_id' => $server->id,
        ]);
    }
}
