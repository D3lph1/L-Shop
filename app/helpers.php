<?php
declare(strict_types = 1);

namespace App;

use App\Services\Settings\Settings;

function setting(string $key, $default = null)
{
    return app(Settings::class)->get($key, $default);
}
