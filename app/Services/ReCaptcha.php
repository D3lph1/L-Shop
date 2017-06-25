<?php

namespace App\Services;

/**
 * Class ReCaptcha
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class ReCaptcha
{
    /**
     * @var string Public ReCAPTCHA key.
     */
    private $publicKey;

    /**
     * @var string Secret ReCAPTCHA key.
     */
    private $secretKey;

    /**
     * @param string $publicKey Public ReCAPTCHA key.
     * @param string $secretKey Secret ReCAPTCHA key.
     */
    public function __construct($publicKey, $secretKey)
    {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
    }

    /**
     * Render the ReCaptcha HTML in at the call site.
     *
     * @param bool $clear If true return the captcha without wrappers in a leveling div.
     *
     * @return string HTML markup.
     */
    public function render($clear = false)
    {
        if ($clear) {
            return "<form id='captcha-form' onsubmit='return false;'>
                        <div class='g-recaptcha' data-sitekey='{$this->publicKey}'></div>
                    </form>";
        }

        return "
            <form id='captcha-form' onsubmit='return false;'>
                <div style='margin-left: calc((100% - 302px)/2); margin-bottom: 1rem'>
                    <div class='g-recaptcha' data-sitekey='{$this->publicKey}'></div>
                </div>
            </form>";
    }

    /**
     * It checks the validity of a response from the ReCaptcha and returns the result.
     *
     * @param string $reCaptchaResponse
     *
     * @param string $ip
     *
     * @return bool
     */
    public function verify($reCaptchaResponse, $ip)
    {
        $reCaptchaResponse = str_replace('g-recaptcha-response=', '', $reCaptchaResponse);
        $url = "https://www.google.com/recaptcha/api/siteverify?response=$reCaptchaResponse&secret={$this->secretKey}&remoteip=$ip";
        $response = $this->send($url);

        if ($response->success) {
            return true;
        }

        return false;
    }

    /**
     * It sends a request to the specified url.
     *
     * @param string $url
     *
     * @return \stdClass mixed
     */
    protected function send($url)
    {
        return json_decode(file_get_contents($url));
    }
}
