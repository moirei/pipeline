<?php

uses()->group('operators', 'concat-operator');

it('should concat pipes', function () {
    $pipe = \pipe::concat(
        fn ($v) => $v * 2
    );

    $value = $pipe->handle(4, $this->pipeline);

    expect($value)->toHaveCount(2);
    expect($value)->toEqual([4, 8]);
});

it('should accept multiple arguments', function () {
    $pipe =  \pipe::concat(
        fn ($v) => $v * 2,
        fn ($v) => $v * 3,
    );

    $value = $pipe->handle(4, $this->pipeline);

    expect($value)->toHaveCount(3);
    expect($value)->toEqual([4, 8, 12]);
});

it('should accept array', function () {
    $pipe = \pipe::concat([
        fn ($v) => $v * 2,
        fn ($v) => $v * 3,
    ]);

    $value = $pipe->handle(4, $this->pipeline);

    expect($value)->toHaveCount(3);
    expect($value)->toEqual([4, 8, 12]);
});
