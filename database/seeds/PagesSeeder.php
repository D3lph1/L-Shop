<?php

use App\Repositories\PageRepository;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    private $repository;

    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->repository->create([
            'id' => 1,
            'title' => __('seeding.pages.0.title'),
            'content' => __('seeding.pages.0.content'),
            'url' => 'welcome-to-L-Shop'
        ]);
    }
}
