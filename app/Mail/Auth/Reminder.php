<?php

namespace App\Mail\Auth;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Mail\Mailable;

class Reminder extends Mailable
{
    /**
     * {@inheritdoc}
     */
    public $subject;

    /**
     * @var \App\Entity\Reminder
     */
    private $reminder;

    /**
     * @var string
     */
    private $ip;

    public function __construct(\App\Entity\Reminder $reminder, string $ip)
    {
        $this->reminder = $reminder;
        $this->ip = $ip;
    }

    public function build(Repository $config, Translator $translator)
    {
        $this->subject = $translator->trans('mail.auth.reminder.subject');

        return $this->view("mail.auth.reminder.{$config->get('app.locale')}", [
            'username' => $this->reminder->getUser()->getUsername(),
            'link' => route('frontend.auth.password.reset.handle', ['code' => $this->reminder->getCode()]),
            'ip' => $this->ip,
            'appName' => $config->get('app.name')
        ]);
    }
}
