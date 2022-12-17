<?php

uses()->group('operators', 'map-operator');

it('should pipe payload through pipe', function () {
    $pipe = \pipe::map(
        fn ($v) => $v * 2
    );

    $value = $pipe->handle([2, 3, 4], $this->pipeline);

    expect($value)->toHaveCount(3);
    expect($value)->toEqual([4, 6, 8]);
});

it('should accept non-array payload', function () {
    $pipe = \pipe::map(
        fn ($v) => $v * 2
    );

    $value = $pipe->handle(2, $this->pipeline);

    expect($value)->toBeArray();
    expect($value)->toHaveCount(1);
    expect($value)->toEqual([4]);
});
