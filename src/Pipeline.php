<?php

namespace MOIREI\Pipeline;

use Closure;
use Illuminate\Contracts\Container\Container;
use RuntimeException;
use Throwable;

class Pipeline
{
    use HasPipelineOperators;

    /**
     * The container implementation.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * The object being passed through the pipeline.
     *
     * @var mixed
     */
    protected $payload;

    /**
     * The context of the pipeline.
     *
     * @var mixed
     */
    protected $context;

    /**
     * The array of class pipes.
     *
     * @var array
     */
    protected $pipes = [];

    /**
     * The method to call on each pipe.
     *
     * @var string
     */
    protected $method = 'handle';

    /**
     * Create a new class instance.
     *
     * @param  \Illuminate\Contracts\Container\Container|null  $container
     * @return void
     */
    public function __construct(Container $container = null)
    {
        $this->container = $container;
    }

    /**
     * Set the object being sent through the pipeline.
     *
     * @param  mixed  $payload
     * @param  mixed  $context
     * @return $this
     */
    public function with($payload, $context = null)
    {
        $this->payload = $payload;
        if (! is_null($context)) {
            $this->context($context);
        }

        return $this;
    }

    /**
     * Set the object being sent through the pipeline.
     *
     * @param  mixed  $payload
     * @return $this
     */
    public function context($context)
    {
        $this->context = is_callable($context) ? $context() : $context;

        return $this;
    }

    /**
     * Set the array of pipes.
     *
     * @param  array|mixed  $pipes
     * @return $this
     */
    public function through($pipes)
    {
        $this->pipes = is_array($pipes) ? $pipes : func_get_args();

        return $this;
    }

    /**
     * Push additional pipes onto the pipeline.
     *
     * @param  array|mixed  $pipes
     * @return $this
     */
    public function push($pipes)
    {
        array_push($this->pipes, ...(is_array($pipes) ? $pipes : func_get_args()));

        return $this;
    }

    /**
     * Push additional pipes onto the pipeline.
     *
     * @param  array|mixed  $pipes
     * @return mixed
     */
    public function pipe($pipes)
    {
        return $this->through(...(is_array($pipes) ? $pipes : func_get_args()))->run();
    }

    /**
     * Set the method to call on the pipes.
     *
     * @param  string  $method
     * @return $this
     */
    public function via(string $method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Run the pipeline with a final destination callback.
     *
     * @param  \Closure  $destination
     * @return mixed
     */
    public function then(Closure $destination)
    {
        $response = array_reduce($this->pipes(), $this->carry(), $this->payload);
        $destination = $this->prepareDestination($destination);

        return $destination($response);
    }

    /**
     * Run the pipeline and return the result.
     *
     * @return mixed
     */
    public function run()
    {
        return $this->then(function ($payload) {
            return $payload;
        });
    }

    /**
     * Process a data through the pipeline and return the result.
     *
     * @param  mixed  $payload
     * @return mixed
     */
    public function process($payload)
    {
        return $this->with($payload)->run();
    }

    /**
     * Get the final piece of the Closure onion.
     *
     * @param  \Closure  $destination
     * @return \Closure
     */
    protected function prepareDestination(Closure $destination)
    {
        return function ($payload) use ($destination) {
            try {
                return $destination($payload);
            } catch (Throwable $e) {
                return $this->handleException($payload, $e);
            }
        };
    }

    /**
     * Get a Closure that represents a slice of the application onion.
     *
     * @return \Closure
     */
    protected function carry()
    {
        /**
         * @param  mixed  $payload
         * @param  Closure|collable  $pipe
         */
        return function ($payload, $pipe) {
            try {
                if ($pipe instanceof Pipe) {
                    // If the pipe is a Pipe instance, then it's called directly with the pipeline.
                    return $pipe->handle($payload, $this);
                }
                if (is_callable($pipe)) {
                    // If the pipe is a callable, then it's called directly.
                    return $pipe($payload);
                } elseif ($pipe instanceof Pipeline) {
                    // if the pipe is a pipeline, process the payload through it
                    // used current context and via method
                    return $pipe->with($payload, $this->context)->via($this->method)->run();
                } elseif (is_string($pipe) && ! class_exists($pipe)) {
                    // if the pipe is a string and not a class, call it as a method
                    // of the context
                    return $this->context->$pipe($payload);
                } elseif (! is_object($pipe)) {
                    [$name, $parameters] = $this->parsePipeString($pipe);

                    // If the pipe is a string we will parse the string and resolve the class out
                    // of the dependency injection container. We can then build a callable and
                    // execute the pipe function giving in the parameters that are required.
                    $pipe = $this->getContainer()->make($name);
                    if (! property_exists($pipe, 'context')) {
                        // set the context for the pipeline
                        $pipe->context = $this->context;
                    }

                    $parameters = array_merge([$payload], $parameters);
                } else {
                    // If the pipe is already an object we'll just make a callable and pass it to
                    // the pipe as-is. There is no need to do any extra parsing and formatting
                    // since the object we're given was already a fully instantiated object.
                    $parameters = [$payload];
                }

                $carry = method_exists($pipe, $this->method)
                    ? $pipe->{$this->method}(...$parameters)
                    : $pipe(...$parameters);

                return $this->handleCarry($carry);
            } catch (Throwable $e) {
                return $this->handleException($payload, $e);
            }
        };
    }

    /**
     * Parse full pipe string to get name and parameters.
     *
     * @param  string  $pipe
     * @return array
     */
    protected function parsePipeString($pipe)
    {
        [$name, $parameters] = array_pad(explode(':', $pipe, 2), 2, []);

        if (is_string($parameters)) {
            $parameters = explode(',', $parameters);
        }

        return [$name, $parameters];
    }

    /**
     * Get the array of configured pipes.
     *
     * @return array
     */
    protected function pipes()
    {
        return $this->pipes;
    }

    /**
     * Get the container instance.
     *
     * @return \Illuminate\Contracts\Container\Container
     *
     * @throws \RuntimeException
     */
    protected function getContainer()
    {
        if (! $this->container) {
            throw new RuntimeException('A container instance has not been passed to the Pipeline.');
        }

        return $this->container;
    }

    /**
     * Set the container instance.
     *
     * @param  \Illuminate\Contracts\Container\Container  $container
     * @return $this
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Handle the value returned from each pipe before passing it to the next.
     *
     * @param  mixed  $carry
     * @return mixed
     */
    protected function handleCarry($carry)
    {
        return $carry;
    }

    /**
     * Handle the given exception.
     *
     * @param  mixed  $payload
     * @param  \Throwable  $e
     * @return mixed
     *
     * @throws \Throwable
     */
    protected function handleException($payload, Throwable $e)
    {
        throw $e;
    }

    /**
     * Clone the pipeline.
     *
     * @return Pipeline
     */
    protected function clone(): Pipeline
    {
        $pipeline = new static($this->container);

        return $pipeline->context($this->context)->via($this->method);
    }
}
