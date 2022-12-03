<?php

uses()->group('operators', 'null-operator');

it('expects null operator to return null', function () {
    $fn = \pipe::null();

    $value = $fn();

    expect($value)->toBeNull();
});
