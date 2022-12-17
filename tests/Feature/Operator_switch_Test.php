<?php

uses()->group('operators', 'switch-operator');

it('should accept array as forks', function () {
    $pipe = \pipe::switch([
        fn ($v) => $v * 2,
        fn ($v) => $v * 4,
    ]);

    $value = $pipe->handle(2, $this->pipeline);

    expect($value)->toHaveCount(2);
    expect($value)->toEqual([4, 8]);
});

it('should accept callable as forks', function () {
    $pipe = \pipe::switch(fn ($payload) => [
        fn ($v) => $v * 2,
        fn ($v) => $v * 4,
    ]);

    $value = $pipe->handle(2, $this->pipeline);

    expect($value)->toHaveCount(2);
    expect($value)->toEqual([4, 8]);
});
