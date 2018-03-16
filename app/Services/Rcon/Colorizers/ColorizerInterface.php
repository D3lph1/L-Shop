<?php
declare(strict_types = 1);

namespace App\Services\Rcon\Colorizers;

/**
 * Interface ColorizerInterface
 * The interface characterizes classes that perform any transformation of data formatted by a Minecraft markup.
 */
interface ColorizerInterface
{
    /**
     * Disassembles the transmitted string and replaces the special characters on the
     * sequence of the specific implementation implementation.
     *
     * @param string $data
     *
     * @return string
     */
    public function colorize(string $data): string;

    /**
     * Colorize the string in a dark blue color.
     *
     * @param string $string
     *
     * @return string
     */
    public function darkBlue(string $string): string;

    /**
     * Colorize the string in a dark green color.
     *
     * @param string $string
     *
     * @return string
     */
    public function darkGreen(string $string): string;

    /**
     * Colorize the string in a dark aqua color.
     *
     * @param string $string
     *
     * @return string
     */
    public function darkAqua(string $string): string;

    /**
     * Colorize the string in a dark red color.
     *
     * @param string $string
     *
     * @return string
     */
    public function darkRed(string $string): string;

    /**
     * Colorize the string in a purple color.
     *
     * @param string $string
     *
     * @return string
     */
    public function purple(string $string): string;

    /**
     * Colorize the string in an orange color.
     *
     * @param string $string
     *
     * @return string
     */
    public function orange(string $string): string;

    /**
     * Colorize the string in a grey color.
     *
     * @param string $string
     *
     * @return string
     */
    public function grey(string $string): string;

    /**
     * Colorize the string in a dark grey color.
     *
     * @param string $string
     *
     * @return string
     */
    public function darkGrey(string $string): string;

    /**
     * Colorize the string in an indigo color.
     *
     * @param string $string
     *
     * @return string
     */
    public function indigo(string $string): string;

    /**
     * Colorize the string in a bright green color.
     *
     * @param string $string
     *
     * @return string
     */
    public function brightGreen(string $string): string;

    /**
     * Colorize the string in a aqua color.
     *
     * @param string $string
     *
     * @return string
     */
    public function aqua(string $string): string;

    /**
     * Colorize the string in a red color.
     *
     * @param string $string
     *
     * @return string
     */
    public function red(string $string): string;

    /**
     * Colorize the string in a pink color.
     *
     * @param string $string
     *
     * @return string
     */
    public function pink(string $string): string;

    /**
     * Colorize the string in an yellow color.
     *
     * @param string $string
     *
     * @return string
     */
    public function yellow(string $string): string;

    /**
     * Colorize the string in a dark blue color.
     *
     * @param string $string
     *
     * @return string
     */
    public function white(string $string): string;

    /**
     * Colorize the string in a black color.
     *
     * @param string $string
     *
     * @return string
     */
    public function black(string $string): string;

    /**
     * Makes the font of a string bold.
     *
     * @param string $string
     *
     * @return string
     */
    public function bold(string $string): string;

    /**
     * Makes the font of the string a strikethrough.
     *
     * @param string $string
     *
     * @return string
     */
    public function lineThrough(string $string): string;

    /**
     * Makes the font of the string a underlined.
     *
     * @param string $string
     *
     * @return string
     */
    public function underline(string $string): string;

    /**
     * Makes the font of the string italic.
     *
     * @param string $string
     *
     * @return string
     */
    public function cursive(string $string): string;
}
