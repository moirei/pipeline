<?php

uses()->group('operators', 'pick-operator');

it('should pick array key from payload', function () {
    $pipe = \pipe::pick(1);

    $value = $pipe->handle([2, 3, 4], $this->pipeline);

    expect($value)->not->toBeArray();
    expect($value)->toEqual(3);
});

it('should return default value for unknown key', function () {
    $pipe = \pipe::pick(2, $default = 8);

    $value = $pipe->handle([2, 3], $this->pipeline);

    expect($value)->toEqual($default);
});

it('should return null for non-array', function () {
    $pipe = \pipe::pick(0);

    $value = $pipe->handle(0, $this->pipeline);

    expect($value)->toBeNull();
});
