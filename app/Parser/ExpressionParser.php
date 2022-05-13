<?php

namespace App\Parser;

use App\Parser\Cron\StarParser;
use App\Parser\Cron\CommaParser;
use App\Parser\Cron\RangeParser;
use App\Parser\Cron\IncrementParser;
use App\Parser\Cron\RangeIncrementParser;

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

    public static function parseYear(string $pattern): string
    {
        return self::parsePattern($pattern, 2022, 2035);
    }

    private static function parsePattern(string $pattern, int $lower, int $upper)
    {
        $starParser = new StarParser($pattern, $lower, $upper);
        $rangeIncrementParser = new RangeIncrementParser($pattern, $lower, $upper);
        $rangeParser = new RangeParser($pattern, $lower, $upper);
        $commaParser = new CommaParser($pattern, $lower, $upper);
        $incrementParser = new IncrementParser($pattern, $lower, $upper);

        if ($starParser->isMatch()) {
            return $starParser->summary();
        }

        if ($rangeIncrementParser->isMatch()) {
            return $rangeIncrementParser->summary();
        }

        if ($commaParser->isMatch()) {
            return $commaParser->summary();
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
