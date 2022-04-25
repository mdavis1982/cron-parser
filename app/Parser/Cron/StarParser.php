<?php

namespace App\Parser\Cron;

class StarParser implements CronParser
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
        return '*' === $this->pattern;
    }

    public function summary(): string
    {
        if (! $this->isMatch()) {
            return 'Not a star match';
        }

        return $this->range->join(' ');
    }
}
