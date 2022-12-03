<?php

namespace MOIREI\Pipeline;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * @method Pipeline clone()
 */
trait HasPipelineOperators
{
    /**
     * Convert the payload data to collection.
     *
     * @return Closure
     */
    public static function collect()
    {
        return function ($payload) {
            return collect($payload);
        };
    }

    /**
     * Filter payload content.
     *
     * @param  callable  $filterFn
     * @return Closure
     */
    public static function filter(callable $filterFn = null)
    {
        $filterFn = $filterFn ?: fn ($item) => (bool) $item;

        return function ($payload) use ($filterFn) {
            $payload = Helpers::wrap($payload);

            return array_filter($payload, fn ($item, $key) => $filterFn($item, $key, $payload), ARRAY_FILTER_USE_BOTH);
        };
    }

    /**
     * Flatten a multi-dimensional payload array into a single level.
     *
     * @param  mixed  $depth
     * @return Closure
     */
    public static function flatten($depth = INF)
    {
        return function ($payload) use ($depth) {
            return Arr::flatten($payload, $depth);
        };
    }

    /**
     * Concat new items into the payload.
     *
     * @param  array|mixed  $pipes
     * @return Closure
     */
    public static function concat($pipes)
    {
        $pipes = is_array($pipes) ? $pipes : func_get_args();

        return function ($payload) use ($pipes) {
            $entries = array_map(fn ($pipe) => $this->clone()->with($payload)->pipe($pipe), $pipes);
            $payload = Helpers::wrap($payload);

            return array_merge($payload, $entries);
        };
    }

    /**
     * Map the payload through the provided pipes.
     *
     * @param  array|mixed  $pipes
     * @return Closure
     */
    public static function map($pipes)
    {
        $pipes = is_array($pipes) ? $pipes : func_get_args();

        return function ($payload) use ($pipes) {
            $payload = Helpers::wrap($payload);

            return array_map(fn ($entry) => $this->clone()->with($entry)->pipe($pipes), $payload);
        };
    }

    /**
     * Merge payload that is an array.
     *
     * @param  callable  $mergeFn
     * @return Closure
     */
    public static function merge(callable $mergeFn = null)
    {
        $mergeFn = $mergeFn ?: function ($arr) {
            $arr = array_map(fn ($x) => $x instanceof Collection ? $x->all() : $x, $arr);

            return array_merge(...$arr);
        };

        return function ($payload) use ($mergeFn) {
            return $mergeFn($payload);
        };
    }

    /**
     * Run the nth item in the payload through the provided pipeline.
     *
     * @param  string|int  $key
     * @param  array  $pipes
     * @return Closure
     */
    public static function nth($key, ...$pipes)
    {
        $pipes = Arr::flatten($pipes);

        return function ($payload) use ($key, $pipes) {
            $payload = Helpers::wrap($payload);
            $data = Arr::get($payload, $key);

            $data = $this->clone()->with($data)->pipe($pipes);

            Arr::set($payload, $key, $data);

            return $payload;
        };
    }

    /**
     * Ignore the payload and return given null.
     *
     * @return Closure
     */
    public static function null()
    {
        return function () {
            return null;
        };
    }

    /**
     * Omit a item from the payload.
     *
     * @param  array|string|int|float  $key
     * @return Closure
     */
    public static function omit($key)
    {
        return function ($payload) use ($key) {
            $payload = Helpers::wrap($payload);

            return Arr::except($payload, $key);
        };
    }

    /**
     * Pipe payload through the provided pipes on condition.
     *
     * @param  mixed  $condition
     * @param  mixed  $pipe
     * @param  mixed  $elsePipe
     * @return Closure
     */
    public static function on($condition, $pipe, $elsePipe = null)
    {
        return function ($payload) use ($condition, $pipe, $elsePipe) {
            if (is_callable($condition)) {
                $condition = $condition($payload);
            }

            if ($condition) {
                $payload = $this->clone()->with($payload)->pipe($pipe);
            } elseif ($elsePipe) {
                $payload = $this->clone()->with($payload)->pipe($elsePipe);
            }

            return $payload;
        };
    }

    /**
     * Pick a item from the payload.
     *
     * @param  string|int|null  $key
     * @param  mixed  $default
     * @return Closure
     */
    public static function pick($key, $default = null)
    {
        return function ($payload) use ($key, $default) {
            return Arr::get($payload, $key, $default);
        };
    }

    /**
     * Concat new items into the payload but prepend.
     *
     * @param  array|mixed  $pipes
     * @return Closure
     */
    public static function prepend($pipes)
    {
        $pipes = is_array($pipes) ? $pipes : func_get_args();

        return function ($payload) use ($pipes) {
            $entries = array_map(fn ($pipe) => $this->clone()->with($payload)->pipe($pipe), $pipes);
            $payload = Helpers::wrap($payload);

            return array_merge($entries, $payload);
        };
    }

    /**
     * Iteratively reduce the payload array to a single value using a callback function.
     *
     * @param callable  $callback
     * @param mixed  $initial
     * @return Closure
     */
    public static function reduce(callable $callback, $initial = null)
    {
        return function ($payload) use ($callback, $initial) {
            $payload = Helpers::wrap($payload);
            return array_reduce($payload, $callback, $initial);
        };
    }

    /**
     * Spread payload as caller arguments.
     *
     * @param  mixed  $handler
     * @return Closure
     */
    public static function spreadArgs($pipe)
    {
        return function ($payload) use ($pipe) {
            $payload = Helpers::wrap($payload);

            if (is_callable($pipe)) {
                /** @var Closure $pipe */
                $pipe = Closure::bind($pipe, $this);

                return $pipe(...$payload);
            } elseif (is_string($pipe) && !class_exists($pipe)) {
                return $this->context->$pipe(...$payload);
            } elseif (!is_object($pipe)) {
                [$name, $parameters] = $this->parsePipeString($pipe);

                $pipe = $this->getContainer()->make($name);
                if (!property_exists($pipe, 'context')) {
                    // set the context for the pipeline
                    $pipe->context = $this->context;
                }

                $parameters = array_merge($payload, $parameters);
            } else {
                $parameters = $payload;
            }

            return method_exists($pipe, $this->method)
                ? $pipe->{$this->method}(...$parameters)
                : $pipe(...$parameters);
        };
    }

    /**
     * Switch the payload through the provided pipes.
     * Resolves an array coresponding to the forks
     *
     * @param  callable|array  $forks
     * @return Closure
     */
    public static function switch(callable|array $forks)
    {
        $forks = is_callable($forks) ? $forks : fn () => $forks;

        return function ($payload) use ($forks) {
            $forks = $forks($payload);
            $forks = Helpers::wrap($forks);

            return array_map(fn ($fork) => $this->clone()->with($payload)->pipe($fork), $forks);
        };
    }

    /**
     * Tap the pipeline.
     *
     * @param  callable|string  $callable
     * @return Closure
     */
    public static function tap(callable|string $callable)
    {
        return function ($payload) use ($callable) {
            if (is_string($callable)) {
                $this->context->$callable($payload);
            } else {
                $callable($payload);
            }

            return $payload;
        };
    }

    /**
     * Switch the payload through the provided pipes.
     * Resolves an array coresponding to the forks
     *
     * @param  int  $number
     * @param  callable  $numberFn
     * @return Closure
     */
    public static function times(int $number, callable $numberFn)
    {
        return function ($payload) use ($number, $numberFn) {
            $array = range(1, $number);
            return array_map(fn ($n) => $numberFn($payload, $n), $array);
        };
    }

    /**
     * Ignore the payload and return given value.
     *
     * @param  mixed  $value
     * @return Closure
     */
    public static function value($value)
    {
        return function () use ($value) {
            return $value;
        };
    }
}
