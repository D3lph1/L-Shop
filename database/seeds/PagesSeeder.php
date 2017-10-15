<?php
declare(strict_types = 1);

use App\Models\Page\PageInterface;
use App\Repositories\Page\PageRepositoryInterface;
use App\Traits\ContainerTrait;
use Illuminate\Database\Seeder;

/**
 * Class PagesSeeder
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 */
class PagesSeeder extends Seeder
{
    use ContainerTrait;

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
            $this->make(PageInterface::class)
                ->setId(1)
                ->setTitle(__('seeding.pages.0.title'))
                ->setContent(__('seeding.pages.0.content'))
                ->setUrl('welcome-to-L-Shop')
        );
    }
}
