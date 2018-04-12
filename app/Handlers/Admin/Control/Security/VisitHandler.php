<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Control\Security;

use App\DataTransferObjects\Admin\Control\Security\VisitResult;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;

class VisitHandler
{
    /**
     * @var Settings
     */
    private $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function handle(): VisitResult
    {
        return (new  VisitResult())
            ->setRecaptchaPublicKey($this->settings->get('system.security.captcha.recaptcha.public_key')->getValue())
            ->setRecaptchaSecretKey($this->settings->get('system.security.captcha.recaptcha.secret_key')->getValue())
            ->setResetPasswordEnabled($this->settings->get('auth.reset_password.enabled')->getValue(DataType::BOOL))
            ->setChangePasswordEnabled($this->settings->get('auth.change_password.enabled')->getValue(DataType::BOOL));
    }
}
