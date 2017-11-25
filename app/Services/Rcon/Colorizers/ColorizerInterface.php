<?php
declare(strict_types = 1);

namespace App\Services\Rcon\Colorizers;

/**
 * Interface ColorizerInterface
 * The interface characterizes classes that perform any transformation of data formatted by a Minecraft markup.
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\Rcon\Colorizers
 */
interface ColorizerInterface
{
    /**
     * Disassembles the transmitted string and replaces the special characters on the
     * sequence of the specific implementation implementation.
     */
    public function colorize(string $data): string;

    /**
     * Colorize the string in a dark blue color.
     */
    public function darkBlue(string $string): string;

    /**
     * Colorize the string in a dark green color.
     */
    public function darkGreen(string $string): string;

    /**
     * Colorize the string in a dark aqua color.
     */
    public function darkAqua(string $string): string;

    /**
     * Colorize the string in a dark red color.
     */
    public function darkRed(string $string): string;

    /**
     * Colorize the string in a purple color.
     */
    public function purple(string $string): string;

    /**
     * Colorize the string in an orange color.
     */
    public function orange(string $string): string;

    /**
     * Colorize the string in a grey color.
     */
    public function grey(string $string): string;

    /**
     * Colorize the string in a dark grey color.
     */
    public function darkGrey(string $string): string;

    /**
     * Colorize the string in an indigo color.
     */
    public function indigo(string $string): string;

    /**
     * Colorize the string in a bright green color.
     */
    public function brightGreen(string $string): string;

    /**
     * Colorize the string in a aqua color.
     */
    public function aqua(string $string): string;

    /**
     * Colorize the string in a red color.
     */
    public function red(string $string): string;

    /**
     * Colorize the string in a pink color.
     */
    public function pink(string $string): string;

    /**
     * Colorize the string in an yellow color.
     */
    public function yellow(string $string): string;

    /**
     * Colorize the string in a dark blue color.
     */
    public function white(string $string): string;

    /**
     * Colorize the string in a black color.
     */
    public function black(string $string): string;

    /**
     * Makes the font of a string bold.
     */
    public function bold(string $string): string;

    /**
     * Makes the font of the string a strikethrough.
     */
    public function lineThrough(string $string): string;

    /**
     * Makes the font of the string a underlined.
     */
    public function underline(string $string): string;

    /**
     * Makes the font of the string italic.
     */
    public function cursive(string $string): string;
}
