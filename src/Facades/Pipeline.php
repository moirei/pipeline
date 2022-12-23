<?php

namespace MOIREI\Pipeline\Facades;

use Illuminate\Support\Facades\Facade;
use MOIREI\Pipeline\Pipe;
use MOIREI\Pipeline\Pipeline as Instance;

/**
 * @method static Instance with($payload, $context = null)
 * @method static Instance flatten(mixed $depth = INF)
 * @method static Instance context(mixed $context)
 * @method static Instance through(array|mixed $pipes)
 * @method static Instance push(array|mixed $pipes)
 * @method static mixed    pipe(array|mixed $pipes)
 * @method static Instance via(string $method)
 * @method static Instance then(\Closure $destination)
 * @method static mixed    run()
 * @method static Pipe  collect()
 * @method static Pipe  concat(array|mixed $pipes)
 * @method static Pipe  map(array|mixed $pipes)
 * @method static Pipe  merge(callable $merger = null)
 * @method static Pipe  nth(string|int $key, array ...$pipes)
 * @method static Pipe  omit(array|string|int|float $key)
 * @method static Pipe  on(mixed $condition, mixed $handler, mixed $else = null)
 * @method static Pipe  pick(string|int|null $key, mixed $default = null)
 * @method static Pipe  spreadArgs(mixed $handler)
 * @method static Pipe  switch(callable|array $switcher)
 * @method static Pipe  tap(callable|string $callable)
 * @method static Pipe  times(int $number, callable $numberFn)
 * @method static Pipe  value(mixed $value)
 */
class Pipeline extends Facade
{
    /**
     * Indicates if the resolved instance should be cached.
     *
     * @var bool
     */
    protected static $cached = false;

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'pipeline';
    }
}
