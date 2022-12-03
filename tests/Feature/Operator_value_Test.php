<?php

uses()->group('operators', 'value-operator');

it('expects value operator to value', function () {
    $fn = \pipe::value(2);

    $value = $fn();

    expect($value)->toEqual(2);
});
