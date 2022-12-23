<?php

namespace MOIREI\Pipeline;

use Closure;

class Pipe
{
    /**
     * The pipe handler.
     *
     * @var Closure|callable
     */
    protected $handler;

    /**
     * Create a new class instance.
     *
     * @param  mixed  $handler
     * @return void
     */
    public function __construct($handler)
    {
        $this->handler = is_callable($handler) ? $handler : fn () => $handler;
    }

    /**
     * Create a new instance.
     *
     * @param  mixed  $handler
     * @return static
     */
    public static function make($handler): static
    {
        return new static($handler);
    }

    /**
     * Handle a payload for pipeline
     *
     * @param  mixed  $payload
     * @param  Pipeline  $pipeline
     * @return mixed
     */
    public function handle($payload, $pipeline)
    {
        $handler = Closure::bind($this->handler, $pipeline);

        return $handler($payload);
    }

    /**
     * Call the pipeline.
     *
     * @param  mixed  $payload
     * @param  Pipeline  $pipeline
     * @return mixed
     */
    public function __invoke($payload, $pipeline)
    {
        return $this->handle($payload, $pipeline);
    }
}
