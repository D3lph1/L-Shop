<?php
declare(strict_types = 1);

namespace App\Services\DateTime\Formatting;

use DateTimeInterface;
use Illuminate\Contracts\Translation\Translator;

class DefaultFormatter implements Formatter
{
    /**
     * @var Translator
     */
    private $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function format(DateTimeInterface $dateTime)
    {
        $month = $dateTime->format('n');
        return $this->translator->trans("datetime.humanized.{$month}", [
            'day' => $dateTime->format('j'),
            'year' => $dateTime->format('Y'),
            'time' => $dateTime->format('H:i:s')
        ]);
    }
}
