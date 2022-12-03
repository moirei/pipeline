<?php

namespace MOIREI\Pipeline\Tests;

use Closure;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Bind fake pipeline to operator
     */
    public function fakePipelineBind(Closure $fn)
    {
        $pipeline = new class
        {
            public $method = 'handle';

            public function clone()
            {
                return pipeline();
            }
        };

        return Closure::bind($fn, $pipeline);
    }
}
