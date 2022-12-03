# Usage

Pipelines can be created and used in multiple ways.

For example a pipeline can be created and used to process multiple data:

```php
$pipeline = Pipeline::through($pipes);
$value = $pipeline->process($payload);
// or
$value = $pipeline->with($payload)->run();
```

Or you can also create and immidiately process data by calling `pipe`

```php
$value = Pipeline::with($payload)->pipe($pipes);
```

## Through vs pipe

The pipeline class has a `through` and a `pipe` method. Using `pipe` immediately applies the provided props and processes the pipeline. On the other hand `through` applies the pipes and returns the pipeline itself.

## Via Method

When using classes for pipes, the default handler method is `handle` or `__invoke`.

Use the `via` method to specified a different handler.

```php
class MyPipe{
  public function myMethod(PayloadType $payload){
    //
  }
}

...

$pipeline = Pipeline::via('myMethod')->through(
  MyPipe::class,
);
```

Not that the specified method has to be consistent with all pipes.
