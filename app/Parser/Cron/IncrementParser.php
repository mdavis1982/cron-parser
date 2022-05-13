<?php

namespace App\Parser\Cron;

class IncrementParser implements CronParser
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
        return preg_match('/^\*|[0-9]+\/[0-9]+$/', $this->pattern);
    }

    public function summary(): string
    {
        if (! $this->isMatch()) {
            return 'Not an increment match';
        }

        [$start, $increment] = explode('/', $this->pattern);

        if ('*' === $start) {
            $start = $this->range->first();
        }

        if ($start < $this->range->first() || $start > $this->range->last()) {
            return 'Invalid range expression: Out of bounds.';
        }

        $summary = '';
        for ($counter = $start; $counter <= $this->range->last(); ++$counter) {
            if (0 === $counter % $increment) {
                $summary .= ' ' . $counter;
            }
        }

        return trim($summary);
    }
}
