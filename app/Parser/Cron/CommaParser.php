<?php

namespace App\Parser\Cron;

class CommaParser implements CronParser
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
        return preg_match('/^[0-9]+(,[0-9]+)*$/', $this->pattern);
    }

    public function summary(): string
    {
        if (! $this->isMatch()) {
            return 'Not a comma match';
        }

        $parts = explode(',', $this->pattern);

        $summary = '';
        foreach ($parts as $part) {
            $summary .= ' ' . $part;
        }

        return trim($summary);
    }
}
