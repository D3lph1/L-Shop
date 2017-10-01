<?php
declare(strict_types = 1);

namespace App\Services\Rcon\Colorizer;

interface ColorizerInterface
{
    public function colorize(string $data): string;

    public function darkBlue(string $string): string;

    public function darkGreen(string $string): string;

    public function darkAqua(string $string): string;

    public function darkRed(string $string): string;

    public function purple(string $string): string;

    public function orange(string $string): string;

    public function grey(string $string): string;

    public function darkGrey(string $string): string;

    public function indigo(string $string): string;

    public function brightGreen(string $string): string;

    public function aqua(string $string): string;

    public function red(string $string): string;

    public function pink(string $string): string;

    public function yellow(string $string): string;

    public function white(string $string): string;

    public function black(string $string): string;

    public function bold(string $string): string;

    public function lineThrough(string $string): string;

    public function underline(string $string): string;

    public function cursive(string $string): string;
}
