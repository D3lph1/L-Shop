<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestMail extends Mailable
{
    use SerializesModels;

    /**
     * @var string
     */
    public $subject;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        $this->subject = __('mail.test.subject');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.test', ['site' => config('app.url')]);
    }
}
