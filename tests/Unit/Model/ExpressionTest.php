<?php

use App\Models\Expression;

test('it can be constructed with a collection of components', function () {
    $expression = new Expression(collect([1, 2, 3, 4, 5, 6]));

    expect($expression)->toBeInstanceOf(Expression::class);
});

test('it can be constructed from a string', function () {
    $expression = Expression::fromString('1 2 3 4 5 6');

    expect($expression)->toBeInstanceOf(Expression::class);
});

test('it reports as valid if it has the correct amount of components', function () {
    $expression = Expression::fromString('1 2 3 4 5 6');

    expect($expression->isValid())->toBeTrue();
    expect($expression->isNotValid())->toBeFalse();
});

test('it reports as invalid if it does not have the correct amount of components', function () {
    $expression = Expression::fromString('1 2 3');

    expect($expression->isNotValid())->toBeTrue();
    expect($expression->isValid())->toBeFalse();
});

test('it returns the command when asking for it', function () {
    $expression = Expression::fromString('*/15 0 1,15 * 1-5 /usr/bin/find');

    expect($expression->command())->toBe('/usr/bin/find');
});

test('it returns the command even when the command contains spaces', function () {
    $expression = Expression::fromString('*/15 0 1,15 * 1-5 /usr/bin/find && /usr/bin/ls');

    expect($expression->command())->toBe('/usr/bin/find && /usr/bin/ls');
});
