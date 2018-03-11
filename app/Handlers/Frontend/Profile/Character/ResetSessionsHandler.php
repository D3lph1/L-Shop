<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Profile\Character;

use App\Services\Auth\Auth;

class ResetSessionsHandler
{
    /**
     * @var Auth
     */
    private $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle(): void
    {
        $this->auth->logout(true);
    }
}
