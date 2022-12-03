<?php

uses()->group('operators', 'flatten-operator');

it('should flatten value', function () {
    $fn = \pipe::flatten();

    $value = $fn([
        [1, 2],
        [3, 4],
    ]);

    expect($value)->toHaveCount(4);
});
