<?php

uses()->group('operators', 'on-operator');

it('should apply pipeline on condition', function () {
    $fn = $this->fakePipelineBind(
        \pipe::on(
            true,
            fn ($v) => $v * 2,
        )
    );

    $value = $fn(2);

    expect($value)->toEqual(4);
});

it('should apply pipeline on callable condition', function () {
    $fn = $this->fakePipelineBind(
        \pipe::on(
            fn () => true,
            fn ($v) => $v * 2,
        )
    );

    $value = $fn(2);

    expect($value)->toEqual(4);
});

it('should apply else pipeline on condition', function () {
    $fn = $this->fakePipelineBind(
        \pipe::on(
            false,
            fn ($v) => $v * 2,
            fn ($v) => $v * 4,
        )
    );

    $value = $fn(2);

    expect($value)->toEqual(8);
});

it('should apply else pipeline on callable condition', function () {
    $fn = $this->fakePipelineBind(
        \pipe::on(
            fn () => false,
            fn ($v) => $v * 2,
            fn ($v) => $v * 4,
        )
    );

    $value = $fn(2);

    expect($value)->toEqual(8);
});
