<?php
declare(strict_types = 1);

namespace App\Mail\Auth;

use App\Services\Infrastructure\Routing\SpaRouteResolver;
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

    public function build(Repository $config, Translator $translator, SpaRouteResolver $resolver)
    {
        $this->subject = $translator->trans('mail.auth.reminder.subject');

        return $this->view("mail.auth.reminder", [
            'username' => $this->reminder->getUser()->getUsername(),
            'link' => $resolver->resolve("/password/reset/{$this->reminder->getCode()}"),
            'ip' => $this->ip,
            'appName' => $config->get('app.name')
        ]);
    }
}
