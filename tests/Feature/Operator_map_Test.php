<?php

uses()->group('operators', 'map-operator');

it('should pipe payload through pipe', function () {
    $fn = $this->fakePipelineBind(
        \pipe::map(
            fn ($v) => $v * 2
        )
    );

    $value = $fn([2, 3, 4]);

    expect($value)->toHaveCount(3);
    expect($value)->toEqual([4, 6, 8]);
});

it('should accept non-array payload', function () {
    $fn = $this->fakePipelineBind(
        \pipe::map(
            fn ($v) => $v * 2
        )
    );

    $value = $fn(2);

    expect($value)->toBeArray();
    expect($value)->toHaveCount(1);
    expect($value)->toEqual([4]);
});
