<?php

namespace App\Models;

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
        return 'TODO: Minute';
    }

    public function hour(): string
    {
        return 'TODO: Hour';
    }

    public function dayOfMonth(): string
    {
        return 'TODO: Day of Month';
    }

    public function month(): string
    {
        return 'TODO: Month';
    }

    public function dayOfWeek(): string
    {
        return 'TODO: Day of Week';
    }

    public function command(): string
    {
        return (string) $this->components->last();
    }
}
