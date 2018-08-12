<?php
declare(strict_types = 1);

namespace App\Services\DateTime\Formatting;

use DateTimeInterface;
use Illuminate\Contracts\Translation\Translator;

/**
 * Class HumanizeFormatter
 * Creates a human-friendly DateTime view.
 */
class HumanizeFormatter implements Formatter
{
    /**
     * @var Translator
     */
    private $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function format(DateTimeInterface $dateTime): string
    {
        $month = $dateTime->format('n');
        return $this->translator->trans("DateTime.humanized.{$month}", [
            'day' => $dateTime->format('j'),
            'year' => $dateTime->format('Y'),
            'time' => $dateTime->format('H:i:s')
        ]);
    }
}
