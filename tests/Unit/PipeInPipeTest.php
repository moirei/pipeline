<?php

it('should create pipeline with pipes', function () {
    $value = pipeline(4)->pipe(
        fn ($v) => $v * 2,
        pipeline()->through(
            fn ($v) => $v * 2
        )
    );
    expect($value)->toEqual(16);
});
