<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public $subject = 'Сброс пароля';

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
     *
     * @param int $userId
     * @param string $username
     * @param string $code
     * @param string $ip
     */
    public function __construct($userId, $username, $code, $ip)
    {
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
