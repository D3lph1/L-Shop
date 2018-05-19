<?php
declare(strict_types = 1);

namespace App\Handlers\Api\Auth;

use App\DataTransferObjects\Frontend\Auth\RegisterResult;
use App\Entity\User;
use App\Exceptions\ForbiddenException;
use App\Services\Auth\Auth;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;

class RegisterHandler
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
     * @param string $email
     * @param string $password
     * @param bool   $sendActivation
     * @param bool   $authenticate
     *
     * @return RegisterResult
     * @throws \Exception
     */
    public function handle(string $username, string $email, string $password, bool $sendActivation, bool $authenticate): RegisterResult
    {
        if ($this->settings->get('api.register_enabled')->getValue(DataType::BOOL)) {
            $user = $this->auth->register(new User($username, $email, $password), !$sendActivation, $authenticate, true);

            $dto = new RegisterResult($user, !$sendActivation);

            return $dto;
        }

        throw new ForbiddenException(
            'API registration is disabled. To enable, set the "api.register.enabled" value to true'
        );
    }
}
