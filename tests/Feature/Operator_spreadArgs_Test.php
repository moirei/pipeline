<?php

uses()->group('operators', 'spreadArgs-operator');

it('should spread payload as arguments to callable', function () {
    $fn = $this->fakePipelineBind(
        \pipe::spreadArgs(
            fn ($v1, $v3) => $v1 + $v3
        )
    );

    $value = $fn([2, 3]);

    expect($value)->toEqual(5);
});

it('should spread payload as arguments to context method', function () {
    $pipeline = new class
    {
        public function __construct()
        {
            $this->context = new class
            {
                public function myMethod($v1, $v3)
                {
                    return $v1 + $v3;
                }
            };
        }

        public function clone()
        {
            return pipeline();
        }
    };

    $fn = \pipe::spreadArgs('myMethod');
    $fn = Closure::bind($fn, $pipeline);

    $value = $fn([2, 3]);

    expect($value)->toEqual(5);
});

it('should spread payload as arguments to object handler', function () {
    $pipe = new class
    {
        public function handle($v1, $v3)
        {
            return $v1 + $v3;
        }
    };

    $fn = $this->fakePipelineBind(
        \pipe::spreadArgs($pipe)
    );

    $value = $fn([2, 3]);

    expect($value)->toEqual(5);
});
