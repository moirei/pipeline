<?php

uses()->group('operators', 'concat-operator');

it('should concat pipes', function () {
    $fn = $this->fakePipelineBind(
        \pipe::concat(
            fn ($v) => $v * 2
        )
    );

    $value = $fn(4);

    expect($value)->toHaveCount(2);
    expect($value)->toEqual([4, 8]);
});

it('should accept multiple arguments', function () {
    $fn = $this->fakePipelineBind(
        \pipe::concat(
            fn ($v) => $v * 2,
            fn ($v) => $v * 3,
        )
    );

    $value = $fn(4);

    expect($value)->toHaveCount(3);
    expect($value)->toEqual([4, 8, 12]);
});

it('should accept array', function () {
    $fn = $this->fakePipelineBind(
        \pipe::concat([
            fn ($v) => $v * 2,
            fn ($v) => $v * 3,
        ])
    );

    $value = $fn(4);

    expect($value)->toHaveCount(3);
    expect($value)->toEqual([4, 8, 12]);
});
