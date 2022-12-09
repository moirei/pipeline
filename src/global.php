<?php

use MOIREI\Pipeline\HasPipelineOperators;
use MOIREI\Pipeline\Pipeline;

if (! function_exists('pipeline')) {
    /**
     * Create a new pipeline
     *
     * @param  mixed  $payload
     * @param  mixed  $pipes
     * @param  mixed  $context
     * @param  string  $method
     * @return Pipeline
     */
    function pipeline(
        $payload = null,
        $pipes = null,
        $context = null,
        string $method = null,
    ) {
        /** @var Pipeline */
        $pipeline = app()->make(Pipeline::class);
        if (! is_null($payload)) {
            $pipeline->with($payload);
        }
        if (! is_null($context)) {
            $pipeline->context($context);
        }
        if (! is_null($method)) {
            $pipeline->via($method);
        }
        if (! is_null($pipes)) {
            return $pipeline->pipe($pipes);
        }

        return $pipeline;
    }
}

if (! class_exists('pipe')) {
    class pipe
    {
        use HasPipelineOperators;
    }
}
