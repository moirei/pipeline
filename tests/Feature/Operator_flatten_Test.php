<?php

uses()->group('operators', 'flatten-operator');

it('should flatten value', function () {
    $pipe = \pipe::flatten();

    $value = $pipe->handle([
        [1, 2],
        [3, 4],
    ], $this->pipeline);

    expect($value)->toHaveCount(4);
});
