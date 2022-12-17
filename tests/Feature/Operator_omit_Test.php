<?php

uses()->group('operators', 'omit-operator');

it('should omit array key from payload', function () {
    $pipe = \pipe::omit(1);

    $value = $pipe->handle([2, 3, 4], $this->pipeline);

    expect($value)->toHaveCount(2);
    expect(array_values($value))->toEqual([2, 4]);
});

it('should accept non-array', function () {
    $pipe = \pipe::omit(1);

    $value = $pipe->handle(2, $this->pipeline);

    expect($value)->toBeArray();
    expect($value)->toHaveCount(1);
    expect($value)->toEqual([2]);
});

it('should accept non-array and remove item at 0', function () {
    $pipe = \pipe::omit(0);

    $value = $pipe->handle(2, $this->pipeline);

    expect($value)->toBeArray();
    expect($value)->toHaveCount(0);
});
