<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Auth;

use App\DataTransferObjects\Frontend\Auth\RegisterResult;
use App\Entity\User;
use App\Services\Auth\Auth;
use App\Services\Auth\Checkpoint\ActivationCheckpoint;
use App\Services\Auth\Checkpoint\Pool;
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

    public function handle(string $username, string $email, string $password): RegisterResult
    {
        $sendActivation = $this->settings->get('auth.register.send_activation')->getValue(DataType::BOOL);
        $user = $this->auth->register(new User($username, $email, $password), !$sendActivation, false, false);
        $dto = new RegisterResult($user, !$sendActivation);

        return $dto;
    }
}
