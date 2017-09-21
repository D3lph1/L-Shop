<?php
declare(strict_types = 1);

use App\DataTransferObjects\Server;
use App\Models\Server\ServerInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Server\ServerRepositoryInterface;
use Illuminate\Database\Seeder;

/**
 * Class ServersSeeder
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 */
class ServersSeeder extends Seeder
{
    /**
     * @var ServerRepositoryInterface
     */
    private $serverRepository;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * ServersSeeder constructor.
     *
     * @param ServerRepositoryInterface   $serverRepository
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(ServerRepositoryInterface $serverRepository, CategoryRepositoryInterface $categoryRepository)
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
        /** @var ServerInterface $server */
        $server = $this->serverRepository->create(
            (new Server())
                ->setId(1)
                ->setName('MMO')
                ->setEnabled(true)
                ->setIp('127.0.0.1')
                ->setPort(25575)
                ->setPassword('123456')
                ->setMonitoringEnabled(false)
        );

        $this->categoryRepository->create(
            (new \App\DataTransferObjects\Category())
                ->setId(1)
                ->setName(__('seeding.categories.1'))
                ->setServerId($server->getId())
        );
        $this->categoryRepository->create(
            (new \App\DataTransferObjects\Category())
                ->setId(2)
                ->setName(__('seeding.categories.2'))
                ->setServerId($server->getId())
        );
        $this->categoryRepository->create(
            (new \App\DataTransferObjects\Category())
                ->setId(5)
                ->setName(__('seeding.categories.5'))
                ->setServerId($server->getId())
        );
    }

    private function createHiTechPvPServer()
    {
        /** @var ServerInterface $server */
        $server = $this->serverRepository->create(
            (new Server())
                ->setId(2)
                ->setName('Hi-Tech (PvP)')
                ->setEnabled(true)
                ->setIp('127.0.0.1')
                ->setPort(25564)
                ->setPassword('123456')
                ->setMonitoringEnabled(false)
        );

        $this->categoryRepository->create(
            (new \App\DataTransferObjects\Category())
                ->setId(3)
                ->setName(__('seeding.categories.3'))
                ->setServerId($server->getId())
        );
    }

    private function createHiTechPvEServer()
    {
        /** @var ServerInterface $server */
        $server = $this->serverRepository->create(
            (new Server())
                ->setId(3)
                ->setName('Hi-Tech (PvE)')
                ->setEnabled(true)
                ->setIp(null)
                ->setPort(null)
                ->setPassword(null)
                ->setMonitoringEnabled(false)
        );

        $this->categoryRepository->create(
            (new \App\DataTransferObjects\Category())
                ->setId(4)
                ->setName(__('seeding.categories.4'))
                ->setServerId($server->getId())
        );
    }
}
