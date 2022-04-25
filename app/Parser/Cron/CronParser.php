<?php

namespace App\Parser\Cron;

interface CronParser
{
    public function __construct(string $pattern, int $lower, int $upper);

    public function isMatch(): bool;
    public function summary(): string;
}
