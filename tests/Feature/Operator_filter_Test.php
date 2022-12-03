<?php

uses()->group('operators', 'filter-operator');

it('should filter value', function () {
    $fn = \pipe::filter();

    $value = $fn([1, 1, 0, null]);

    expect($value)->toHaveCount(2);
});

it('should use custom filter function', function () {
    $fn = \pipe::filter(fn ($v) => is_numeric($v));

    $value = $fn([1, 1, 0, null]);

    expect($value)->toHaveCount(3);
});
