# Best practices

## Use strict types

It is recommended to explicitely define expected types all through your pipes. Espetially when working with complex pieplines. This would allow you to ensure your pipes receive the expected data type.

For example, the below will fail on `locations` since we're expecting a `Collection` and not an `array`.

```php

class GetLineItemRates{
  public function handle(
    LineItem $line,
    ShippingProfile $shippingProfile,
    Collection $locations
  ){
    //
  }
}

$shippingRates = Pipeline::with($checkout)->pipe(
  GetShippableItems::class,
  Pipeline::map(
    Pipeline::concat(GetLineItemShippingProfile::class),
    Pipeline::concat(
      Pipeline::pick(1),
      fn (ShippingProfile $shippingProfile) => $shippingProfile->locations->toArray(),
    ),
    Pipeline::spreadArgs(GetLineItemRates::class),
  ),
  ...
);
```
