# Context

Pipelines are generally atomic and each pipe is stateless. But in some cases you might want to hold a common state reference as you progress through your pipes.
The example below allows the pipes to add error messages into a common message bag which is then validated by the final operator.

```php
use Illuminate\Support\MessageBag;

class CalculateShipping{
  public MessageBag $errors;

  public function __construct(
    public Checkout $checkout
  ){
    $this->errors = new MessageBag();
  }

  public function calculate(){
    return pipeline($this->checkout)->context($this)->pipe(
      GetShippableItems::class,
      ...,
      Pipeline::tap(function(){
        $this->checkout->errors->fillFrom($this->errors);
      }),
      Pipeline::on(
        fn () => $this->errors->isEmpty(),
        CreateShippingMethods::class,
        fn () => collect([]), // return an empty collection
      ),
    );
  }
}

...

/**
 * @property CalculateShipping $context
 */
class GetShippableItems{
  public function handle(Checkout $checkout)
  {
    /** @var Collection */
    $lines = $checkout->lines()->requiresShipping()->get();
    if ($lines->isEmpty()) {
      $this->context->errors->add('items', 'No items to calculate shipping methods');
    }

    return $lines;
  }
}

...

$checkout = Checkout::find($token);
$shippingMethodCalculator = new CalculateShipping($checkout);
$shippingMethods = $shippingMethodCalculator->calculate();

if (!$shippingMethodCalculator->errors->isEmpty()) {
  //
}
```
