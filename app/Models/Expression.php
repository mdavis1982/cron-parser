<?php

namespace App\Models;

use App\Parser\ExpressionParser;
use Illuminate\Support\Collection;

class Expression
{
    /** @var Collection */
    private $components;

    public function __construct(Collection $components)
    {
        $this->components = $components;
    }

    public static function fromString(string $expression): self
    {
        $components = collect(explode(' ', $expression));

        $combined = $components->slice(0, 5)
            ->push($components->slice(5)->join(' '))
            ->filter(fn ($component) => '' !== $component)
        ;

        return new self($combined);
    }

    public function isValid(): bool
    {
        return 6 === $this->components->count();
    }

    public function isNotValid(): bool
    {
        return ! $this->isValid();
    }

    public function minute(): string
    {
        return ExpressionParser::parseMinute((string) $this->components[0]);
    }

    public function hour(): string
    {
        return ExpressionParser::parseHour((string) $this->components[1]);
    }

    public function dayOfMonth(): string
    {
        return ExpressionParser::parseDayOfMonth((string) $this->components[2]);
    }

    public function month(): string
    {
        return ExpressionParser::parseMonth((string) $this->components[3]);
    }

    public function dayOfWeek(): string
    {
        return ExpressionParser::parseDayOfWeek((string) $this->components[4]);
    }

    public function command(): string
    {
        return (string) $this->components->last();
    }
}
