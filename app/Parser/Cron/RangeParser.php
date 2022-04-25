<?php

namespace App\Parser\Cron;

class RangeParser implements CronParser
{
    /** @var string */
    private $pattern;

    /** @var Collection */
    private $range;

    public function __construct(string $pattern, int $lower, int $upper)
    {
        $this->pattern = $pattern;
        $this->range = collect(range($lower, $upper));
    }

    public function isMatch(): bool
    {
        return preg_match('/[0-9]+\-[0-9]+/', $this->pattern);
    }

    public function summary(): string
    {
        if (! $this->isMatch()) {
            return 'Not a range match';
        }

        [$lower, $upper] = explode('-', $this->pattern);

        if ($lower > $upper) {
            return 'Invalid range expression: Range is the wrong way around.';
        }

        if ($lower < $this->range->first() || $upper > $this->range->last()) {
            return 'Invalid range expression: Out of bounds.';
        }

        return implode(' ', range($lower, $upper));
    }
}
