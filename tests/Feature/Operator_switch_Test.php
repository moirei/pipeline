<?php

uses()->group('operators', 'switch-operator');

it('should accept array as forks', function () {
    $fn = $this->fakePipelineBind(
        \pipe::switch([
            fn ($v) => $v * 2,
            fn ($v) => $v * 4,
        ])
    );

    $value = $fn(2);

    expect($value)->toHaveCount(2);
    expect($value)->toEqual([4, 8]);
});

it('should accept callable as forks', function () {
    $fn = $this->fakePipelineBind(
        \pipe::switch(fn ($payload) => [
            fn ($v) => $v * 2,
            fn ($v) => $v * 4,
        ])
    );

    $value = $fn(2);

    expect($value)->toHaveCount(2);
    expect($value)->toEqual([4, 8]);
});
