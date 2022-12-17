# Operators

## `collect`

Converts pipeline payload to `Collection`.

```php
$collection = pipeline()->with([1, 2, 3])->pipe(
  \pipe::map(fn ($v) => $v * 2),
  \pipe::collect(),
);
```

## `filter`

Performs a filter operation on the payload. Payload is wrapped as an array if it's not one.

```php
$value = pipeline([2, 3, null])->pipe(
  \pipe::filter(),
);

// yields [2, 3]
```

You can provide a custom filter function

```php
...
\pipe::filter(function($value, $key, $payload){
  //
}),
...
```

## `flatten`

Flattens a multi-dimensional payload array into a single level array.

Uses `Arr::flatten()`.

```php
$flatArray = pipeline()->with([
    [1, 2]
    [3, 4]
])->pipe(
  \pipe::flatten(),
);
```

Can also provide depth

```php
\pipe::flatten(2)
```

## `concat`

Concats values from provided pipes to the payload.

```php
$value = pipeline(3)->pipe(
  \pipe::concat(
    fn ($v) => $v * 2,
    fn ($v) => $v * 3,
    ...
  ),
);

// yields [3, 6, 9, ...]
```

Also accepts an array

```php
$value = pipeline(3)->pipe(
  \pipe::concat([
    fn ($v) => $v * 2,
    fn ($v) => $v * 4,
  ]),
);
```

If you want to concat pipes that depend on the result of the previous concat, call them separately

```php
$value = pipeline(3)->pipe(
  \pipe::concat(fn ($v) => $v * 2),
  \pipe::concat(fn (array $payload) => $payload[1] * 4),
);

// yields [3, 6, 24]
```

Same as below with `nth`

```php
$value = pipeline(3)->pipe(
  \pipe::concat(fn ($v) => $v * 2),
  \pipe::concat(\pipe::nth(1, fn ($v) => $v * 4)),
);
```

## `map`

Runs the values of the payload through the given pipeline. If payload is not an array, it's wrapped around one.

```php
$value = pipeline([2, 3])->pipe(
  \pipe::map(
    fn ($v) => $v * 2,
    ...
  )
);

// yields [4, 6]
```

## `merge`

Merges the elements of one or more arrays in the payload together.

```php
$value = pipeline()->with([
  [1, 2]
  [3, 4]
])->pipe(
  \pipe::merge(),
);
```

## `nth`

Runs the _nth_ item in the payload through the provided pipeline.

```php
$value = pipeline([2, 3, 4])->pipe(
  \pipe::nth(1,
    fn ($v) => $v * 2,
    ...
  ),
);

// yields [2, 6, 4]
```

Also accepts an array.

```php
$value = pipeline([2, 3, 4])->pipe(
  \pipe::nth(1, [
    fn ($v) => $v * 2,
    ...
  ]),
);
```

## `null`

Ignore the payload and return `null`.

```php
$pipeline = pipeline()->through(
  \pipe::on(
    fn ($v) => is_numeric($v),
    fn ($v) => $v * 2,
    \pipe::null(),
  ),
);

$pipeline->process(2); // returns 4
$pipeline->process('two'); // returns null
```

## `omit`

Omit the specified key or array of keys from the payload.

Uses `Arr::except()`.

```php
$value = pipeline([2, 3, 4])->pipe(
  \pipe::omit(1),
);

// yields [2, 4]
```

## `on`

On a given condition run the payload through the pipeline.

Uses `Arr::except()`.

```php
$value = pipeline()->pipe(
  \pipe::on($condition,
    fn ($v) => $v * 2,
  ),
);
```

Also accepts `callable` as condition argument as an else pipeline

```php
$value = pipeline()->pipe(
  \pipe::on(
    fn ($payload) => is_numeric($payload),
    fn ($v) => $v * 2,
    fn ($v) => 0, // else
  ),
);
```

## `pick`

Picks the specified key from the payload. Accepts "dot" notation

Uses `Arr::get()`.

```php
$value = pipeline()->with([2, 4])->pipe(
  \pipe::pick(1),
);

// yields 4
```

## `prepend`

Like `concat` but prepends results to the front of the payload.

## `reduce`

Iteratively reduce the payload array to a single value using a callback function.

```php
$value = pipeline([0, 1, 2, 3])->pipe(
  \pipe::reduce(fn ($carry, $v) => $carry + $v),
);
```

Also accepts a defualt value

```php
\pipe::reduce(fn ($carry, $v) => $carry + $v, 1),
```

## `spreadArgs`

This is practically not an operator.

In the event the payload is an array of values, `spreadArgs` may be used to wrap the pipe in order to use payload values as arguments.

```php

class CalculateShippingMethods{
  public function handle(CheckoutLine $line, ShippingProfile $shippingProfile, Collection $locations){
    //
  }
}

...

$methods = pipeline($checkout)->pipe(
  GetShippableItems::class,
  \pipe::map(
    \pipe::concat(
      GetShippingProfile::class,
      GetLocations::class,
    ),
    \pipe::spreadArgs(CalculateShippingMethods::class, ...)
    \pipe::spreadArgs(
      \pipe::tap(function(CheckoutLine $line, ...){
        //
      })
    )
  ),
  \pipe::merge()
);
```

Also accepts closures and pipes as usual

```php
\pipe::spreadArgs([
  fn ($v) => $v * 2,
  pipeline()->through(
    ...
  ),
])
```

## `switch`

Forks the payload data through provided pipelines and returns an array representation of each result.

This operator only accepts an array of pipes or a function that returns an array of pipes.

```php
$value = pipeline(2)->pipe(
  \pipe::switch([
    fn ($v) => $v * 2,
    fn ($v) => $v * 4,
    fn ($v) => $v * 6,
  ]),
);

// yields [4, 8, 12]
```

Use a function if you need to access the payload data

```php
\pipe::switch(fn ($payload) => [
  fn ($v) => $v * 2,
  fn ($v) => $v * 4,
  fn ($v) => $v * 6,
]),
```

## `tap`

The operator does not make.

Allows you to tap into the payload at any given stage.

```php
$value = pipeline(2)->pipe(
  \pipe::tap(
    function($payload){
      //
    },
    MyPipe::class,
  ),
);
```

You can also call a method defined in the context.

```php

$context = new class{
  public function myMethod($payload){
    dump($myMethod);
    // logs 2
  }
};

pipeline(2)->context($context)->pipe(
  \pipe::tap('myMethod'),
);
```

## `times`

Run the payload through the provided function a number of times.

```php
$value = pipeline(1)->pipe(
  \pipe::times(4, fn ($payload, $number) => ($number * 2) + $payload)
);

// yields [3, 5, 7, 9]
```

## `value`

Ignore the payload and return given value.

```php
$pipeline = pipeline()->through(
  \pipe::on(
    fn ($v) => is_numeric($v),
    fn ($v) => $v * 2,
    \pipe::value(0),
  ),
);

$pipeline->process(2); // returns 4
$pipeline->process(null); // returns 0
```
