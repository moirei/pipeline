<?php

use MOIREI\Pipeline\Facades\Pipeline;
use MOIREI\Pipeline\Pipeline as Instance;
use MOIREI\Pipeline\PipelineServiceProvider;

beforeEach(function () {
    app()->register(PipelineServiceProvider::class);
});

it('should create pipeline using facade', function () {
    $pipeline = Pipeline::with([1]);
    expect($pipeline)->toBeInstanceOf(Instance::class);
    expect(invade($pipeline)->payload)->toEqual([1]);
});

it('should create pipeline using facade and operators', function () {
    $value = Pipeline::with(1)->pipe(
        Pipeline::concat(Pipeline::value(2)),
        Pipeline::map(
            fn ($v) => $v * 2
        )
    );
    expect($value)->toEqual([2, 4]);
});
