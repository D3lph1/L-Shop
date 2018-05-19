<?php
declare(strict_types = 1);

namespace App\Handlers\Api\Auth;

use App\Exceptions\ForbiddenException;
use App\Services\Auth\Auth;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;

class LoginHandler
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var Settings
     */
    private $settings;

    public function __construct(Auth $auth, Settings $settings)
    {
        $this->auth = $auth;
        $this->settings = $settings;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return bool
     * @throws ForbiddenException
     */
    public function handle(string $username, string $password)
    {
        if ($this->settings->get('api.login_enabled')->getValue(DataType::BOOL)) {
            return $this->auth->authenticate($username, $password, true);
        }

        throw new ForbiddenException(
            'API authentication is disabled. To enable, set the "api.login" value to true'
        );
    }
}
