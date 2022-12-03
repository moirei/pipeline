<?php

uses()->group('operators', 'omit-operator');

it('should omit array key from payload', function () {
    $fn = \pipe::omit(1);

    $value = $fn([2, 3, 4]);

    expect($value)->toHaveCount(2);
    expect(array_values($value))->toEqual([2, 4]);
});

it('should accept non-array', function () {
    $fn = \pipe::omit(1);

    $value = $fn(2);

    expect($value)->toBeArray();
    expect($value)->toHaveCount(1);
    expect($value)->toEqual([2]);
});

it('should accept non-array and remove item at 0', function () {
    $fn = \pipe::omit(0);

    $value = $fn(2);

    expect($value)->toBeArray();
    expect($value)->toHaveCount(0);
});
