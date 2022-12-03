# Creating Pipes

## Closures

The basic way to defined a pipe is passing closures.

```php
$value = pipeline([2, 4])->pipe(
  fn ($v) => $v * 2
);
```

## Class pipes

It's recommended to use dedicated pipe classes. This would allow you to exhaustively test each pipe's functionality.

```php
class MyPipe{
  public function __construct(protected DependencyType $dependency)
  {
    //
  }

  public function handle(ExpectedType $payload)
  {
    //
  }
}
```

You can use `__invoke` to call an instance of the pipe as a function.

```php
class MyPipe{
  public function __invoke(ExpectedType $payload)
  {
    //
  }
}
```

Class pipes can be used by provide the class name or an instance of the instance.

```php
$value = pipeline(...)->pipe(
  MyPipe::class,
  // or
  new MyPipe,
);
```

## Nested pipelines

It is possible to nest multiple pipelines. But to do so you must use the `through` method instead of `pipe`.

```php
$value = pipeline(...)->pipe(
  \pipe::switch([
    pipeline()->through(
      \pipe::map(...),
      ...
    ),
    ...
  ]),
  ...
);
```

## Context methods

If you'er using context's, you may pipe to a method defined in the context.
Use if you want all your pipes to be encapsulated in one class.

```php
class Calculator{
  public function sum(array $v){
    return sum($v);
  }
  public function mutipleByTwo(int $v){
    return $v * 2;
  }
}

$calculator = new Calculator();

$value = pipeline([2, 4], context: $calculator)->pipe(
  'sum',
  'mutipleByTwo',
);

// or

$value = pipeline([2, 4])->context($calculator)->pipe(
  'sum',
  'mutipleByTwo',
);

// or

$value = Pipeline::with([2, 4])->context($calculator)->pipe(
  'sum',
  'mutipleByTwo',
);
```
