<?php

namespace MOIREI\Pipeline\Facades;

use Illuminate\Support\Facades\Facade;
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
 * @method static Closure  collect()
 * @method static Closure  concat(array|mixed $pipes)
 * @method static Closure  map(array|mixed $pipes)
 * @method static Closure  merge(callable $merger = null)
 * @method static Closure  nth(string|int $key, array ...$pipes)
 * @method static Closure  omit(array|string|int|float $key)
 * @method static Closure  on(mixed $condition, mixed $handler, mixed $else = null)
 * @method static Closure  pick(string|int|null $key, mixed $default = null)
 * @method static Closure  spreadArgs(mixed $handler)
 * @method static Closure  switch(callable|array $switcher)
 * @method static Closure  tap(callable|string $callable)
 * @method static Closure  times(int $number, callable $numberFn)
 * @method static Closure  value(mixed $value)
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
