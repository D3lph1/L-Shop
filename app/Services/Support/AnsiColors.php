<?php
declare(strict_types = 1);

namespace App\Services\Support;

/**
 * Class AnsiColors
 * Represents constants with ANSI colors.
 */
class AnsiColors
{
    public const BLACK = "\033[0;30m";

    public const BLUE = "\033[0;34m";

    public const GREEN = "\033[0;32m";

    public const CYAN = "\033[0;36m";

    public const RED = "\033[0;31m";

    public const PURPLE = "\033[0;35m";

    public const ORANGE = "\033[0;33m";

    public const LIGHT_GRAY = "\033[0;37m";

    public const DARK_GRAY = "\033[1;30m";

    public const LIGHT_BLUE = "\033[1;34m";

    public const LIGHT_GREEN = "\033[1;32m";

    public const LIGHT_CYAN = "\033[1;36m";

    public const LIGHT_RED = "\033[1;31m";

    public const LIGHT_PURPLE = "\033[1;35m";

    public const YELLOW = "\033[1;33m";

    public const WHITE = "\033[1;37m";

    /**
     * A sequence marking the end of formatting.
     */
    public const RESET = "\033[0m";

    public const BOLD = "\033[1m";

    private function __construct()
    {
        //
    }
}
