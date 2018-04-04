<?php
declare(strict_types = 1);

namespace App\Services\Rcon\Colorizers;

/**
 * Class StripColorizer
 * Removes Minecraft markup from the string.
 */
class StripColorizer implements Colorizer
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
                $code = preg_split("/[&§][0-9a-z]/", $individual);
                preg_match("/[&§][0-9a-z]/", $individual, $prefix);
                if (isset($prefix[0])){
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
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function darkGreen(string $string): string
    {
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function darkAqua(string $string): string
    {
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function darkRed(string $string): string
    {
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function purple(string $string): string
    {
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function orange(string $string): string
    {
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function grey(string $string): string
    {
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function darkGrey(string $string): string
    {
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function indigo(string $string): string
    {
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function brightGreen(string $string): string
    {
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function aqua(string $string): string
    {
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function red(string $string): string
    {
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function pink(string $string): string
    {
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function yellow(string $string): string
    {
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function white(string $string): string
    {
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function black(string $string): string
    {
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function bold(string $string): string
    {
        return $string;
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
