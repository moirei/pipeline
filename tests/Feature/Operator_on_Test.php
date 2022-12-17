<?php

uses()->group('operators', 'on-operator');

it('should apply pipeline on condition', function () {
    $pipe = \pipe::on(
        true,
        fn ($v) => $v * 2,
    );

    $value = $pipe->handle(2, $this->pipeline);

    expect($value)->toEqual(4);
});

it('should apply pipeline on callable condition', function () {
    $pipe = \pipe::on(
        fn () => true,
        fn ($v) => $v * 2,
    );

    $value = $pipe->handle(2, $this->pipeline);

    expect($value)->toEqual(4);
});

it('should apply else pipeline on condition', function () {
    $pipe = \pipe::on(
        false,
        fn ($v) => $v * 2,
        fn ($v) => $v * 4,
    );

    $value = $pipe->handle(2, $this->pipeline);

    expect($value)->toEqual(8);
});

it('should apply else pipeline on callable condition', function () {
    $pipe = \pipe::on(
        fn () => false,
        fn ($v) => $v * 2,
        fn ($v) => $v * 4,
    );

    $value = $pipe->handle(2, $this->pipeline);

    expect($value)->toEqual(8);
});
