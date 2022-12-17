<?php

uses()->group('operators', 'reduce-operator');

it('should reduce array value', function () {
    $pipe = \pipe::reduce(fn ($carry, $v) => $carry + $v);

    $value = $pipe->handle([0, 1, 2, 3], $this->pipeline);

    expect($value)->toEqual(6);
});

it('should reduce array value with an initial value', function () {
    $pipe = \pipe::reduce(fn ($carry, $v) => $carry + $v, 3);

    $value = $pipe->handle([0, 1, 2, 3], $this->pipeline);

    expect($value)->toEqual(9);
});
