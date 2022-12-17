<?php

uses()->group('operators', 'collect-operator');

it('should convert to collection', function () {
    $fn = \pipe::collect();

    $collection = $fn->handle([1, 1], $this->pipeline);

    expect($collection)->toBeCollection();
    expect($collection->count())->toEqual(2);
});
