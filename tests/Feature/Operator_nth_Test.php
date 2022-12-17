<?php

uses()->group('operators', 'nth-operator');

it('should apply pipeline to nth item in payload', function () {
    $pipe = \pipe::nth(
        1,
        fn ($v) => $v * 2,
    );

    $value = $pipe->handle([2, 3, 4], $this->pipeline);

    expect($value)->toHaveCount(3);
    expect($value)->toEqual([2, 6, 4]);
});

it('should accept multiple arguments as pipes to nth item in payload', function () {
    $pipe = \pipe::nth(
        1,
        fn ($v) => $v * 2,
        fn ($v) => $v * 4,
    );

    $value = $pipe->handle([2, 3, 4], $this->pipeline);

    expect($value)->toHaveCount(3);
    expect($value)->toEqual([2, 24, 4]);
});

it('should accept array pipes to nth item in payload', function () {
    $pipe = \pipe::nth(
        1,
        fn ($v) => $v * 2,
        fn ($v) => $v * 4,
    );

    $value = $pipe->handle([2, 3, 4], $this->pipeline);

    expect($value)->toHaveCount(3);
    expect($value)->toEqual([2, 24, 4]);
});

it('should accept non-array payload', function () {
    $pipe = \pipe::nth(
        0,
        fn ($v) => $v * 2,
    );

    $value = $pipe->handle(2, $this->pipeline);

    expect($value)->toBeArray();
    expect($value)->toHaveCount(1);
    expect($value)->toEqual([4]);
});
