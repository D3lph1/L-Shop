<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\News;

use App\DataTransferObjects\Admin\News\Add;
use App\Entity\News;
use App\Repository\News\NewsRepository;
use App\Services\Auth\Auth;

class AddHandler
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var NewsRepository
     */
    private $repository;

    public function __construct(Auth $auth, NewsRepository $repository)
    {
        $this->auth = $auth;
        $this->repository = $repository;
    }

    public function handle(Add $dto): void
    {
        $this->repository->create(new News(
            $dto->getTitle(),
            $dto->getContent(),
            $this->auth->getUser()
        ));
    }
}
