<?php

uses()->group('operators', 'prepend-operator');

it('should prepend pipes', function () {
    $fn = $this->fakePipelineBind(
        \pipe::prepend(
            fn ($v) => $v * 2
        )
    );

    $value = $fn(4);

    expect($value)->toHaveCount(2);
    expect($value)->toEqual([8, 4]);
});

it('should accept multiple arguments', function () {
    $fn = $this->fakePipelineBind(
        \pipe::prepend(
            fn ($v) => $v * 2,
            fn ($v) => $v * 3,
        )
    );

    $value = $fn(4);

    expect($value)->toHaveCount(3);
    expect($value)->toEqual([8, 12, 4]);
});

it('should accept array', function () {
    $fn = $this->fakePipelineBind(
        \pipe::prepend([
            fn ($v) => $v * 2,
            fn ($v) => $v * 3,
        ])
    );

    $value = $fn(4);

    expect($value)->toHaveCount(3);
    expect($value)->toEqual([8, 12, 4]);
});
