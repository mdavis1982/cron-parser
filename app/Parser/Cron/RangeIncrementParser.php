<?php

namespace App\Parser\Cron;

class RangeIncrementParser implements CronParser
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
        return preg_match('/[0-9]+\-[0-9]+\/[0-9]+/', $this->pattern);
    }

    public function summary(): string
    {
        if (! $this->isMatch()) {
            return 'Not a range increment';
        }

        [$range, $increment] = explode('/', $this->pattern);

        $ranges = (new RangeParser($range, $this->range->first(), $this->range->last()))->summary();
        $ranges = collect(explode(' ', $ranges));

        return (new IncrementParser('*/' . $increment, (int) $ranges->first(), (int) $ranges->last()))->summary();
    }
}
