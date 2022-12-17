<?php

uses()->group('operators', 'null-operator');

it('expects null operator to return null', function () {
    $pipe = \pipe::null();

    $value = $pipe->handle(0, $this->pipeline);

    expect($value)->toBeNull();
});
