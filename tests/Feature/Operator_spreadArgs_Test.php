<?php

uses()->group('operators', 'spreadArgs-operator');

it('should spread payload as arguments to callable', function () {
    $pipe = \pipe::spreadArgs(
        fn ($v1, $v3) => $v1 + $v3
    );

    $value = $pipe->handle([2, 3], $this->pipeline);

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

    $pipe = \pipe::spreadArgs('myMethod');

    $value = $pipe->handle([2, 3], $pipeline);

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

    $pipe = \pipe::spreadArgs($pipe);

    $value = $pipe->handle([2, 3], $this->pipeline);

    expect($value)->toEqual(5);
});
