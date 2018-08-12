<?php
declare(strict_types = 1);

namespace Tests\Unit\Services\DateTime;

use App\Services\DateTime\DateTimeUtil;
use Tests\TestCase;

class DateTimeUtilTest extends TestCase
{
    public function testAddMinutes(): void
    {
        $result = DateTimeUtil::addMinutes(new \DateTimeImmutable('31 december 2018'), 2);
        self::assertEquals((new \DateTimeImmutable('31 december 2018 + 2 minutes'))->getTimestamp(), $result->getTimestamp(), '', 1);
    }

    public function testNowAdd(): void
    {
        $result = DateTimeUtil::nowAdd(\DateInterval::createFromDateString('21 seconds'));
        self::assertEquals((new \DateTimeImmutable('+21 seconds'))->getTimestamp(), $result->getTimestamp(), '', 1);
    }

    public function testNowAddMinutes(): void
    {
        $result = DateTimeUtil::nowAddMinutes(7);
        self::assertEquals((new \DateTimeImmutable('+7 minutes'))->getTimestamp(), $result->getTimestamp(), '', 1);
    }

    public function testNowSub(): void
    {
        $result = DateTimeUtil::nowSub(\DateInterval::createFromDateString('4 week'));
        self::assertEquals((new \DateTimeImmutable('-4 week'))->getTimestamp(), $result->getTimestamp(), '', 1);
    }

    public function testNowSubMinutes(): void
    {
        $result = DateTimeUtil::nowSubMinutes(3);
        self::assertEquals((new \DateTimeImmutable('-3 minutes'))->getTimestamp(), $result->getTimestamp(), '', 1);
    }
}
