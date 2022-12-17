<?php

uses()->group('operators', 'merge-operator');

it('should merge value', function () {
    $pipe = \pipe::merge();

    $value = $pipe->handle([
        [1, 2],
        [3, 4],
    ], $this->pipeline);

    expect($value)->toHaveCount(4);
});
