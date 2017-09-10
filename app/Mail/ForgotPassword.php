<?php
declare(strict_types = 1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class ForgotPassword
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Mail
 */
class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public $subject;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $ip;

    /**
     * Create a new message instance.
     */
    public function __construct(int $userId, string $username, string $code, string $ip)
    {
        $this->subject = __('mail.forgot_password.subject');
        $this->userId = $userId;
        $this->username = $username;
        $this->code = $code;
        $this->ip = $ip;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.forgot_password', [
            'userId' => $this->userId,
            'username' => $this->username,
            'code' => $this->code,
            'ip' => $this->ip
        ]);
    }
}
