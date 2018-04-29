<?php
declare(strict_types = 1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Test extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Build the message.
     *
     * @param Repository $config
     *
     * @param Translator $translator
     *
     * @return $this
     */
    public function build(Repository $config, Translator $translator)
    {
        $this->subject = $translator->trans('mail.test.subject');

        return $this->view('mail.test', [
            'appName' => $config->get('app.name')
        ]);
    }
}
