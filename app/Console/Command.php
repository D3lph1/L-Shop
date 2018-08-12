<?php
declare(strict_types = 1);

namespace App\Console;

use Illuminate\Console\Command as BaseCommand;

/**
 * Class Command
 * Fix of class {@see \Illuminate\Console\Command} for multi-byte character sets.
 * And also adds additional functionality.
 */
class Command extends BaseCommand
{
    public function alert($string)
    {
        $this->comment(str_repeat('*', mb_strlen($string) + 12));
        $this->comment('*     ' . $string . '     *');
        $this->comment(str_repeat('*', mb_strlen($string) + 12));

        $this->output->newLine();
    }

    public function displayErrors(array $errors): void
    {
        foreach ($errors as $error) {
            foreach ($error as $each) {
                $this->error($each);
            }
        }
    }
}
