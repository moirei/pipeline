# Creating Pipelines

## Facade

The default way to start with Pipelines is using the package's facade. All operators can also be accessed via the Facade.

```php
use MOIREI\Pipeline\Facades\Pipeline;

...

$value = Pipeline::with([2, 3])->pipe([
  Pipeline::map(
    fn ($v) => $v * 2,
  ),
  Pipeline::collect(),
  fn (Collection $v) => $v->sum()
]);
```

## Using global functions

The above can be re-written using the available global function `pipeline` and class `pipe`.

```php
$value = pipeline([2, 3])->pipe([
  \pipe::map(
    fn ($v) => $v * 2,
  ),
  \pipe::collect(),
  fn (Collection $v) => $v->sum()
]);
```

### `pipeline`

```php
pipeline(
  $payload,
  $pipes,
  $context,
  $method, // the via method
);
```

If `pipes` in not null, the pipeline is immidiatedly processed and the resulting value is returned

```php
$value = pipeline(2, [
  \pipe::map(fn ($v) => $v * 2)
]);
```

Otherwise the pipeline instance is returned

```php
$pipeline = pipeline(2);

$value = $pipeline->pipe([
  \pipe::map(fn ($v) => $v * 2)
])
```

### `pipe`

This a global class which exposes the operators as static methods for easy namespaced access.

We don't want `\pipe::collect` overriding Laravel's `collect` function.
