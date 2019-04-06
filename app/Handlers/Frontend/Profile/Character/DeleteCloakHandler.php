<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Profile\Character;

use App\Services\Auth\Auth;
use App\Services\Media\Character\Cloak\Image;
use Illuminate\Filesystem\Filesystem;

class DeleteCloakHandler
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(Auth $auth, Filesystem $filesystem)
    {
        $this->auth = $auth;
        $this->filesystem = $filesystem;
    }

    public function handle(): bool
    {
        $username = $this->auth->getUser()->getUsername();
        if (!Image::exists($username)) {
            return false;
        }

        return $this->filesystem->delete(Image::absolutePath($username));
    }
}
