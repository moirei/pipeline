<?php

uses()->group('operators', 'filter-operator');

it('should filter value', function () {
    $pipe = \pipe::filter();

    $value = $pipe->handle([1, 1, 0, null], $this->pipeline);

    expect($value)->toHaveCount(2);
});

it('should use custom filter function', function () {
    $pipe = \pipe::filter(fn ($v) => is_numeric($v));

    $value = $pipe->handle([1, 1, 0, null], $this->pipeline);

    expect($value)->toHaveCount(3);
});
