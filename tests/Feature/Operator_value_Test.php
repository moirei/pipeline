<?php

uses()->group('operators', 'value-operator');

it('expects value operator to value', function () {
    $pipe = \pipe::value(2);

    $value = $pipe->handle(0, $this->pipeline);

    expect($value)->toEqual(2);
});
