<?php

uses()->group('operators', 'times-operator');

it('should convert to collection', function () {
    $fn = \pipe::times(4, fn ($v, $n) => ($n * 2) + $v);

    $value = $fn(1);

    expect($value)->toBeArray();
    expect($value)->toEqual([3, 5, 7, 9]);
});
