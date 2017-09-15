<?php
declare(strict_types = 1);

use App\Repositories\Page\PageRepositoryInterface;
use Illuminate\Database\Seeder;

/**
 * Class PagesSeeder
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 */
class PagesSeeder extends Seeder
{
    /**
     * @var PageRepositoryInterface
     */
    private $repository;

    public function __construct(PageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->repository->create(
            (new \App\DataTransferObjects\Page())
                ->setId(1)
                ->setTitle(__('seeding.pages.0.title'))
                ->setContent(__('seeding.pages.0.content'))
                ->setUrl('welcome-to-L-Shop')
        );
    }
}
