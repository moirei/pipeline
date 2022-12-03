<?php

use MOIREI\Pipeline\Pipeline;

it('should create pipeline', function () {
    $pipeline = pipeline();
    expect($pipeline)->toBeInstanceOf(Pipeline::class);
});

it('should create pipeline with data', function () {
    $pipeline = pipeline([1]);
    expect(invade($pipeline)->payload)->toEqual([1]);
});

it('should create pipeline with context', function () {
    $context = (object) [];
    $pipeline = pipeline(null, null, $context);
    expect(invade($pipeline)->context)->toEqual($context);
});

it('should create pipeline with via method', function () {
    $pipeline = pipeline(null, null, null, 'viaMethod');
    expect(invade($pipeline)->method)->toEqual('viaMethod');
});

it('should create pipeline with pipes and return value', function () {
    $pipes = [
        fn ($v) => $v * 2,
    ];
    $value = pipeline(4, $pipes);
    expect($value)->toEqual(8);
});
