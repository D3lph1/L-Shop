<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class UserActivation
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Mail
 */
class UserActivation extends Mailable
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
     * Create a new message instance.
     *
     * @param int $userId
     * @param string $username
     * @param string $code
     */
    public function __construct($userId, $username, $code)
    {
        $this->subject = __('mail.user_activation.subject');
        $this->userId = $userId;
        $this->username = $username;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.user_activation', [
            'userId' => $this->userId,
            'username' => $this->username,
            'code' => $this->code
        ]);
    }
}
