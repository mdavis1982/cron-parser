<?php

it('accepts a valid cron expression as an argument', function () {
    $this->artisan('parse "*/15 0 1,15 * 1-5 /usr/bin/find"')
        ->assertSuccessful()
    ;
});

it('asks for a cron expression if one is not provided', function () {
    $this->artisan('parse')
        ->expectsQuestion('What is the cron expression you want to parse?', '*/15 0 1,15 * 1-5 /usr/bin/find')
        ->assertSuccessful()
    ;
});

it('errors if the cron expression is not valid', function () {
    $this->artisan('parse "1 2 3 4 5"')
        ->assertFailed()
    ;
});
