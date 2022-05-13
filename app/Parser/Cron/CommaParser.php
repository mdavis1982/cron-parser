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
        return preg_match('/[0-9]+(,[0-9]+)*([0-9]+\-[0-9]+)*/', $this->pattern);
    }

    public function summary($dump = false): string
    {
        if (! $this->isMatch()) {
            return 'Not a comma match';
        }

        $parts = explode(',', $this->pattern);

        $summary = '';
        foreach ($parts as $part) {
            if (mb_strpos($part, '-')) {
                [$lower, $upper] = explode('-', $part);

                $part = (new RangeParser($part, $lower, $upper))->summary();
            }

            $summary .= ' ' . $part;
        }

        return trim($summary);
    }
}
