<?php

namespace App\Commands;

use App\Models\Expression;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

class ParseCronCommand extends Command
{
    /** @var string */
    protected $signature = 'parse
                            { expression? : The cron expression to parse }
    ';

    /** @var string */
    protected $description = 'Parse a cron expression into its component parts and display a summary.';

    public function handle()
    {
        $expression = $this->getExpression();

        if ($expression->isNotValid()) {
            $this->error('The cron expression was not valid.');

            return self::FAILURE;
        }

        $this->outputSummary($expression);

        return self::SUCCESS;
    }

    private function getExpression(): Expression
    {
        // We try to get the passed expression.
        // If an expression wasn't passed on the CLI, then we are going to ask for one.
        $expression = $this->argument('expression') ?? $this->ask('What is the cron expression you want to parse?');

        return Expression::fromString($expression);
    }

    public function outputSummary(Expression $expression)
    {
        $this->outputMetric('minute', $expression->minute());
        $this->outputMetric('hour', $expression->hour());
        $this->outputMetric('day of month', $expression->dayOfMonth());
        $this->outputMetric('month', $expression->month());
        $this->outputMetric('day of week', $expression->dayOfWeek());
        $this->outputMetric('command', $expression->command());
    }

    private function outputMetric(string $name, string $value)
    {
        $this->line(
            sprintf(
                '<info>%s</info>%s',
                Str::padRight($name, 14),
                $value
            )
        );
    }
}
