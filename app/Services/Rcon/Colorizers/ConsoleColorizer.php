<?php
declare(strict_types = 1);

namespace App\Services\Rcon\Colorizers;

use App\Services\Support\AnsiColors;

/**
 * Class ConsoleColorizer
 * Converts the Minecraft markup into color codes ansi for output on console.
 */
class ConsoleColorizer implements Colorizer
{
    /**
     * {@inheritdoc}
     */
    public function colorize(string $data): string
    {
        preg_match_all('/[^§&]*[^§&]|[§&][0-9a-z][^§&]*/', $data, $brokenUpStr);
        $returnStr = '';
        foreach ($brokenUpStr as $results){
            $ending = '';
            foreach ($results as $individual){
                $code = preg_split('/[&§][0-9a-z]/', $individual);
                preg_match('/[&§][0-9a-z]/', $individual, $prefix);
                if (isset($prefix[0])){
                    $actualcode = substr($prefix[0], 1);
                    switch ($actualcode){
                        case "1":
                            $returnStr = $returnStr . AnsiColors::BLUE;
                            $ending = $ending . AnsiColors::RESET;
                            break;
                        case '2':
                            $returnStr = $returnStr . AnsiColors::GREEN;
                            $ending = $ending . AnsiColors::RESET;
                            break;
                        case '3':
                            $returnStr = $returnStr . AnsiColors::CYAN;
                            $ending = $ending . AnsiColors::RESET;
                            break;
                        case '4':
                            $returnStr = $returnStr . AnsiColors::RED;
                            $ending = $ending . AnsiColors::RESET;
                            break;
                        case '5':
                            $returnStr = $returnStr . AnsiColors::PURPLE;
                            $ending = $ending . AnsiColors::RESET;
                            break;
                        case '6':
                            $returnStr = $returnStr . AnsiColors::ORANGE;
                            $ending = $ending . AnsiColors::RESET;
                            break;
                        case '7':
                            $returnStr = $returnStr . AnsiColors::LIGHT_GRAY;
                            $ending = $ending . AnsiColors::RESET;
                            break;
                        case '8':
                            $returnStr = $returnStr . AnsiColors::DARK_GRAY;
                            $ending = $ending . AnsiColors::RESET;
                            break;
                        case '9':
                            $returnStr = $returnStr . AnsiColors::LIGHT_BLUE;
                            $ending = $ending . AnsiColors::RESET;
                            break;
                        case 'a':
                            $returnStr = $returnStr . AnsiColors::LIGHT_GREEN;
                            $ending = $ending . AnsiColors::RESET;
                            break;
                        case 'b':
                            $returnStr = $returnStr . AnsiColors::LIGHT_CYAN;
                            $ending = $ending . AnsiColors::RESET;
                            break;
                        case 'c':
                            $returnStr = $returnStr . AnsiColors::LIGHT_RED;
                            $ending = $ending . AnsiColors::RESET;
                            break;
                        case 'd':
                            $returnStr = $returnStr . AnsiColors::LIGHT_PURPLE;
                            $ending = $ending . AnsiColors::RESET;
                            break;
                        case 'e':
                            $returnStr = $returnStr . AnsiColors::YELLOW;
                            $ending = $ending . AnsiColors::RESET;
                            break;
                        case 'f':
                            $returnStr = $returnStr . AnsiColors::BLACK;
                            $ending = $ending . AnsiColors::RESET;
                            break;
                        case 'l':
                            if (strlen($individual) > 2){
                                $returnStr = $returnStr . AnsiColors::BOLD;
                                $ending = AnsiColors::RESET . $ending;
                                break;
                            }
                            break;
                        case 'r':
                            $returnStr = $returnStr.$ending;
                            $ending = '';
                            break;
                    }

                    if (isset($code[1])){
                        $returnStr = $returnStr . $code[1];
                        if (isset($ending) && strlen($individual) > 2){
                            $returnStr = $returnStr.$ending;
                            $ending = '';
                        }
                    }
                }
                else{
                    $returnStr = $returnStr . $individual;
                }
            }
        }

        return $returnStr;
    }

    /**
     * {@inheritdoc}
     */
    public function darkBlue(string $string): string
    {
        return AnsiColors::BLUE . $string . AnsiColors::RESET;
    }

    /**
     * {@inheritdoc}
     */
    public function darkGreen(string $string): string
    {
        return AnsiColors::GREEN . $string . AnsiColors::RESET;
    }

    /**
     * {@inheritdoc}
     */
    public function darkAqua(string $string): string
    {
        return AnsiColors::CYAN . $string . AnsiColors::RESET;
    }

    /**
     * {@inheritdoc}
     */
    public function darkRed(string $string): string
    {
        return AnsiColors::RED . $string . AnsiColors::RESET;
    }

    /**
     * {@inheritdoc}
     */
    public function purple(string $string): string
    {
        return AnsiColors::PURPLE . $string . AnsiColors::RESET;
    }

    /**
     * {@inheritdoc}
     */
    public function orange(string $string): string
    {
        return AnsiColors::ORANGE . $string . AnsiColors::RESET;
    }

    /**
     * {@inheritdoc}
     */
    public function grey(string $string): string
    {
        return AnsiColors::LIGHT_GRAY . $string . AnsiColors::RESET;
    }

    /**
     * {@inheritdoc}
     */
    public function darkGrey(string $string): string
    {
        return AnsiColors::DARK_GRAY . $string . AnsiColors::RESET;
    }

    /**
     * {@inheritdoc}
     */
    public function indigo(string $string): string
    {
        return AnsiColors::LIGHT_BLUE . $string . AnsiColors::RESET;
    }

    /**
     * {@inheritdoc}
     */
    public function brightGreen(string $string): string
    {
        return AnsiColors::LIGHT_GREEN . $string . AnsiColors::RESET;
    }

    /**
     * {@inheritdoc}
     */
    public function aqua(string $string): string
    {
        return AnsiColors::LIGHT_CYAN . $string . AnsiColors::RESET;
    }

    /**
     * {@inheritdoc}
     */
    public function red(string $string): string
    {
        return AnsiColors::RED . $string . AnsiColors::RESET;
    }

    /**
     * {@inheritdoc}
     */
    public function pink(string $string): string
    {
        return AnsiColors::LIGHT_RED . $string . AnsiColors::RESET;
    }

    /**
     * {@inheritdoc}
     */
    public function yellow(string $string): string
    {
        return AnsiColors::YELLOW . $string . AnsiColors::RESET;
    }

    /**
     * {@inheritdoc}
     */
    public function white(string $string): string
    {
        return AnsiColors::WHITE . $string . AnsiColors::RESET;
    }

    /**
     * {@inheritdoc}
     */
    public function black(string $string): string
    {
        return AnsiColors::BLACK . $string . AnsiColors::RESET;
    }

    /**
     * {@inheritdoc}
     */
    public function bold(string $string): string
    {
        return AnsiColors::BOLD . $string . AnsiColors::RESET;
    }

    /**
     * {@inheritdoc}
     */
    public function lineThrough(string $string): string
    {
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function underline(string $string): string
    {
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function cursive(string $string): string
    {
        return $string;
    }
}
