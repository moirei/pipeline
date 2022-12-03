# Rationale

Sometimes Pipeline Pattern is what does the job. The example described in this page takes a single input (a checkout model) and spits out a collection of shipping methods. What happens in-between is an combination of a group of small functions (pipes).

An important thing to note is all the pipe classes can be fully unit tested in isolation irrespective of the complexity.

```php
// all pipes may access our context
$context = new class(){
    public MessageBag $errors;

    public function __construct()
    {
        $this->errors = new MessageBag();
    }
};

$shippingMethods = Pipeline::with($checkout, $context)->pipe(
    Pipeline::tap(ValidateCheckout::class), // validate items count, shipping address, etc.
    GetShippableItems::class,
    Pipeline::map(
        // get available rates for each item
        Pipeline::concat(GetLineItemShippingProfile::class), // add shipping profile
        Pipeline::concat(GetLineItemLocations::class), // uses shipping profile to retrive locations
        Pipeline::spreadArgs(GetLineItemZoneRates::class), // uses item, profile, and locations to get rates
    ),
    Pipeline::collect(),
    CombinRates::class, // combine all rates
    Pipeline::tap(ValidateItemStock::class), // validate available stock for final rates
    Pipeline::tap(function () {
        // save any errors to the checkout instance
        if ($context->errors->isNotEmpty()) {
            $checkout->errors->fillFrom($context->errors);
        }
    }),
    Pipeline::on(
        fn () => $context->errors->isEmpty(),
        CreateShippingMethods::class, // persist shipping methods if we've everything is ok
        fn () => collect([]),
    ),
);
```

This being a simplied version of a much complex pipeline; the original solution uses `switch`, `pick`, `nth`, `merge`, `omit` operators and even nested pipes to further get rates per location types and shipping profiles.
