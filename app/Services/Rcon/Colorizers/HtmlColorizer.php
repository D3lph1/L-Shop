<?php
declare(strict_types = 1);

namespace App\Services\Rcon\Colorizers;

class HtmlColorizer implements ColorizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function colorize(string $data): string
    {
        preg_match_all('/[^§&]*[^§&]|[§&][0-9a-z][^§&]*/', $data, $brokenUpStr);
        $returnStr = '<span>';
        foreach ($brokenUpStr as $results){
            $ending = '';
            foreach ($results as $individual){
                $code = preg_split("/[&§][0-9a-z]/", $individual);
                preg_match("/[&§][0-9a-z]/", $individual, $prefix);
                if (isset($prefix[0])){
                    $actualcode = substr($prefix[0], 1);
                    switch ($actualcode){
                        case '1':
                            $returnStr = $returnStr. '<span style="color: #0000AA;">';
                            $ending = $ending . '</span>';
                            break;
                        case '2':
                            $returnStr = $returnStr . '<span style="color: #00AA00;">';
                            $ending =$ending . '</span>';
                            break;
                        case '3':
                            $returnStr = $returnStr .'<span style="color: #00AAAA">';
                            $ending = $ending . '</span>';
                            break;
                        case '4':
                            $returnStr = $returnStr.'<span style="color: #AA0000">';
                            $ending =$ending . '</span>';
                            break;
                        case '5':
                            $returnStr = $returnStr.'<span style="color: #AA00AA">';
                            $ending = $ending . '</span>';
                            break;
                        case '6':
                            $returnStr = $returnStr.'<span style="color: #FFAA00">';
                            $ending = $ending . '</span>';
                            break;
                        case '7':
                            $returnStr = $returnStr.'<span style="color: #AAAAAA">';
                            $ending = $ending . '</span>';
                            break;
                        case '8':
                            $returnStr = $returnStr.'<span style="color: #555555">';
                            $ending =$ending . '</span>';
                            break;
                        case '9':
                            $returnStr = $returnStr . '<span style="color: #5555FF">';
                            $ending =$ending . '</span>';
                            break;
                        case 'a':
                            $returnStr = $returnStr . '<span style="color: #55FF55">';
                            $ending =$ending . '</span>';
                            break;
                        case 'b':
                            $returnStr = $returnStr . '<span style="color: #55FFFF">';
                            $ending = $ending . '</span>';
                            break;
                        case 'c':
                            $returnStr = $returnStr . '<span style="color: #FF5555">';
                            $ending =$ending . '</span>';
                            break;
                        case 'd':
                            $returnStr = $returnStr . '<span style="color: #FF55FF">';
                            $ending =$ending . '</span>';
                            break;
                        case 'e':
                            $returnStr = $returnStr . '<span style="color: #FFFF55">';
                            $ending = $ending . "</span>";
                            break;
                        case 'f':
                            $returnStr = $returnStr . '<span style="color: #333">';
                            $ending =$ending . '</span>';
                            break;
                        case 'l':
                            if (strlen($individual) > 2){
                                $returnStr = $returnStr . '<span style="font-weight:bold;">';
                                $ending = '</span>' . $ending;
                                break;
                            }
                            break;
                        case 'm':
                            if (strlen($individual)>2){
                                $returnStr = $returnStr. '<span style="text-decoration: line-through;">';
                                $ending = "</span>" . $ending;
                                break;
                            }
                            break;
                        case 'n':
                            if (strlen($individual)>2){
                                $returnStr = $returnStr . '<span style="text-decoration: underline;">';
                                $ending = '</span>' . $ending;
                                break;
                            }
                            break;
                        case 'o':
                            if (strlen($individual)>2){
                                $returnStr = $returnStr . '<i>';
                                $ending = '</i>' . $ending;
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

        return $returnStr . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function darkBlue(string $string): string
    {
        return '<span style="color: #0000AA;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function darkGreen(string $string): string
    {
        return '<span style="color: #00AA00;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function darkAqua(string $string): string
    {
        return '<span style="color: #00AAAA;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function darkRed(string $string): string
    {
        return '<span style="color: #AA0000;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function purple(string $string): string
    {
        return '<span style="color: #AA00AA;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function orange(string $string): string
    {
        return '<span style="color: #FFAA00;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function grey(string $string): string
    {
        return '<span style="color: #AAAAAA;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function darkGrey(string $string): string
    {
        return '<span style="color: #555555;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function indigo(string $string): string
    {
        return '<span style="color: #5555FF;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function brightGreen(string $string): string
    {
        return '<span style="color: #55FF55;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function aqua(string $string): string
    {
        return '<span style="color: #55FFFF;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function red(string $string): string
    {
        return '<span style="color: #FF5555;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function pink(string $string): string
    {
        return '<span style="color: #FF55FF;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function yellow(string $string): string
    {
        return '<span style="color: #FFFF55;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function white(string $string): string
    {
        return '<span style="color: #fff;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function black(string $string): string
    {
        return '<span style="color: #000;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function bold(string $string): string
    {
        return '<span style="font-weight:bold;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function lineThrough(string $string): string
    {
        return '<span style="text-decoration: line-through;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function underline(string $string): string
    {
        return '<span style="text-decoration: underline;">' . $string . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function cursive(string $string): string
    {
        return '<i>' . $string . '</i>';
    }
}
