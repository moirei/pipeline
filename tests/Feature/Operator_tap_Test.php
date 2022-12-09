<?php

use MOIREI\Pipeline\Facades\Pipeline;
use MOIREI\Pipeline\PipelineServiceProvider;

uses()->group('operators', 'tap-operator');

beforeEach(function () {
    app()->register(PipelineServiceProvider::class);
});

it('expect pipeline to call local method', function () {
    $this->context = \Mockery::spy('TestContext');

    $pipeline = Pipeline::through([
        Pipeline::tap(function () {
            $this->context->testFunction();
        }),
    ]);

    $pipeline->process(10);

    $this->context->shouldHaveReceived('testFunction');
});

it('expect pipeline to call context method', function () {
    $context = \Mockery::spy('TestContext');

    $pipeline = Pipeline::context($context)->through([
        Pipeline::tap('testFunction'),
    ]);

    $pipeline->process(10);

    $context->shouldHaveReceived('testFunction', [10]);
});

it('expect pipeline to pipe instance', function () {
    $pipe = \Mockery::mock(new class
    {
        public function handle()
        {
            //
        }
    });

    $pipeline = Pipeline::through([
        Pipeline::tap($pipe),
    ]);

    $pipeline->process(10);

    $pipe->shouldHaveReceived('handle', [10]);
});

it('expect pipeline accept arrays', function () {
    $this->context = \Mockery::spy('TestContext');

    $pipe = \Mockery::mock(new class
    {
        public function handle()
        {
            //
        }
    });

    $pipeline = Pipeline::context($this->context)->through([
        Pipeline::tap([
            'testFunction1',
            $pipe,
            function ($value) {
                $this->context->testFunction2($value);
            },
        ]),
    ]);

    $pipeline->process(10);

    $this->context->shouldHaveReceived('testFunction1', [10]);
    $this->context->shouldHaveReceived('testFunction2', [10]);
    $pipe->shouldHaveReceived('handle', [10]);
});
