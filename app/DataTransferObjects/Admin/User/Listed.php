<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\User;

use App\Models\User\UserInterface;

/**
 * Class Listed
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\DataTransferObjects\Admin\User
 */
class Listed
{
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var iterable
     */
    private $userCartContent;

    public function __construct(UserInterface $user, iterable $userCartContent)
    {
        $this->user = $user;
        $this->userCartContent = $userCartContent;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getUserCartContent(): iterable
    {
        return $this->userCartContent;
    }
}
