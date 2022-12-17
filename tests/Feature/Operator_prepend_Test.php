<?php

uses()->group('operators', 'prepend-operator');

it('should prepend pipes', function () {
    $pipe = \pipe::prepend(
        fn ($v) => $v * 2
    );

    $value = $pipe->handle(4, $this->pipeline);

    expect($value)->toHaveCount(2);
    expect($value)->toEqual([8, 4]);
});

it('should accept multiple arguments', function () {
    $pipe = \pipe::prepend(
        fn ($v) => $v * 2,
        fn ($v) => $v * 3,
    );

    $value = $pipe->handle(4, $this->pipeline);

    expect($value)->toHaveCount(3);
    expect($value)->toEqual([8, 12, 4]);
});

it('should accept array', function () {
    $pipe = \pipe::prepend([
        fn ($v) => $v * 2,
        fn ($v) => $v * 3,
    ]);

    $value = $pipe->handle(4, $this->pipeline);

    expect($value)->toHaveCount(3);
    expect($value)->toEqual([8, 12, 4]);
});
