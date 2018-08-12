<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Profile\Character;

use App\Services\Auth\Auth;
use App\Services\Media\Character\Cloak\Image;

class DeleteCloakHandler
{
    /**
     * @var Auth
     */
    private $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle(): bool
    {
        $username = $this->auth->getUser()->getUsername();
        if (!Image::exists($username)) {
            return false;
        }

        return \File::delete(Image::absolutePath($username));
    }
}
