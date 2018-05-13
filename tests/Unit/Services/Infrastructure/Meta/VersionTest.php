<?php
declare(strict_types = 1);

namespace Tests\Unit\Services\Infrastructure\Meta;

use App\Services\Meta\AdditionalVersion\ReleaseCandidate;
use App\Services\Meta\Version;
use Tests\TestCase;

class VersionTest extends TestCase
{
    public function testFormatted(): void
    {
        $version = new Version(1, 0, 4);
        self::assertFalse($version->hasAdditionalVersion());
        self::assertEquals('1.0.4', $version->formatted());
    }

    public function testFormattedWithRc(): void
    {
        $version = new Version(3, 5, 1, new ReleaseCandidate(2));
        self::assertTrue($version->hasAdditionalVersion());
        self::assertEquals('3.5.1-rc2', $version->formatted());
    }
}
