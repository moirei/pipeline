<?php

uses()->group('operators', 'times-operator');

it('should convert to collection', function () {
    $pipe = \pipe::times(4, fn ($v, $n) => ($n * 2) + $v);

    $value = $pipe->handle(1, $this->pipeline);

    expect($value)->toBeArray();
    expect($value)->toEqual([3, 5, 7, 9]);
});
