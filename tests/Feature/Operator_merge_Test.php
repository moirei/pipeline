<?php

uses()->group('operators', 'merge-operator');

it('should merge value', function () {
    $fn = \pipe::merge();

    $value = $fn([
        [1, 2],
        [3, 4],
    ]);

    expect($value)->toHaveCount(4);
});
