<?php

uses()->group('operators', 'collect-operator');

it('should convert to collection', function () {
    $fn = \pipe::collect();

    $collection = $fn([1, 1]);

    expect($collection)->toBeCollection();
    expect($collection->count())->toEqual(2);
});
