<?php
declare(strict_types = 1);

namespace App\Services\Security\Captcha;

class ReCaptcha implements Captcha
{
    /**
     * @var string
     */
    private $publicKey;

    /**
     * @var string
     */
    private $secretKey;

    public function __construct(string $publicKey, string $secretKey)
    {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
    }

    public function verify(string $recaptchaResponse, string $ip): bool
    {
        $reCaptchaResponse = str_replace('g-recaptcha-response=', '', $recaptchaResponse);
        $url = "https://www.google.com/recaptcha/api/siteverify?response=$reCaptchaResponse&secret={$this->secretKey}&remoteip={$ip}";
        $response = $this->send($url);

        if ($response->success) {
            return true;
        }

        return false;
    }

    public function view(): string
    {
        return view('components.captcha.recaptcha', ['key' => $this->publicKey])->render();
    }

    private function send(string $url): \stdClass
    {
        return json_decode(file_get_contents($url));
    }
}
