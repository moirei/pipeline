<?php

uses()->group('operators', 'pick-operator');

it('should pick array key from payload', function () {
    $fn = \pipe::pick(1);

    $value = $fn([2, 3, 4]);

    expect($value)->not->toBeArray();
    expect($value)->toEqual(3);
});

it('should return default value for unknown key', function () {
    $fn = \pipe::pick(2, $default = 8);

    $value = $fn([2, 3]);

    expect($value)->toEqual($default);
});

it('should return null for non-array', function () {
    $fn = \pipe::pick(0);

    $value = $fn(0);
    expect($value)->toBeNull();
});
