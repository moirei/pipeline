# Laravel Pipeline

Amongst several pipeline packages, including [Laravel's very own package](https://github.com/illuminate/pipeline), you might want a solution with a bit more regor for complex operations.

This package is intended for data processing and should not be a replacement for actions nor jobs. The concept of a pipeline here is a structured collection of micro tasks that happen in succession in order to yield a single output from a single input.

## Documentation

All documentation is available at [the documentation site](https://moirei.github.io/pipeline).

## Features

- Utility operators
- Pipeline context
- Use closures, handler classes or context methods

## Example

If you're used to RxJs, you might have an appreciation for the below example. There's technically no limit to what can be done with pipelines.

```php
$value = Pipeline::with(0)->pipe([
    Pipeline::switch([
        fn ($v) => $v + 1,
        fn ($v) => $v + 2,
        fn ($v) => $v + 3,
    ]),
    Pipeline::map(
        fn ($v) => $v * 2,
    ),
    Pipeline::tap(function (array $value) {
        // do whatever
    }),
]);

// returns [2, 4, 6]
```

See [rationale](https://moirei.github.io/pipeline/rationale) for a more exciting example.

## Installation

```bash
composer require moirei/pipeline
```

## Tests

```bash
composer test
```

## Credits

- [illuminate/pipeline](https://github.com/illuminate/pipeline)
