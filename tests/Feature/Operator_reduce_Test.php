<?php

uses()->group('operators', 'reduce-operator');

it('should reduce array value', function () {
    $fn = \pipe::reduce(fn ($carry, $v) => $carry + $v);

    $value = $fn([0, 1, 2, 3]);

    expect($value)->toEqual(6);
});

it('should reduce array value with an initial value', function () {
    $fn = \pipe::reduce(fn ($carry, $v) => $carry + $v, 3);

    $value = $fn([0, 1, 2, 3]);

    expect($value)->toEqual(9);
});
