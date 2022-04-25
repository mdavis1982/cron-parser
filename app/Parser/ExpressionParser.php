<?php

namespace App\Parser;

use App\Parser\Cron\StarParser;
use App\Parser\Cron\RangeParser;
use App\Parser\Cron\IncrementParser;

class ExpressionParser
{
    public static function parseMinute(string $pattern): string
    {
        return self::parsePattern($pattern, 0, 59);
    }

    public static function parseHour(string $pattern): string
    {
        return self::parsePattern($pattern, 0, 23);
    }

    public static function parseDayOfMonth(string $pattern): string
    {
        return self::parsePattern($pattern, 1, 31);
    }

    public static function parseMonth(string $pattern): string
    {
        return self::parsePattern($pattern, 0, 11);
    }

    public static function parseDayOfWeek(string $pattern): string
    {
        return self::parsePattern($pattern, 1, 7);
    }

    private static function parsePattern(string $pattern, int $lower, int $upper)
    {
        $starParser = new StarParser($pattern, $lower, $upper);
        $rangeParser = new RangeParser($pattern, $lower, $upper);
        $incrementParser = new IncrementParser($pattern, $lower, $upper);

        if ($starParser->isMatch()) {
            return $starParser->summary();
        }

        if ($rangeParser->isMatch()) {
            return $rangeParser->summary();
        }

        if ($incrementParser->isMatch()) {
            return $incrementParser->summary();
        }

        return 'Invalid expression';
    }
}
