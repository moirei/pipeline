<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(MOIREI\Pipeline\Tests\TestCase::class)
  ->beforeEach(function () {
    $this->pipeline = new class
    {
      public $method = 'handle';

      public function clone()
      {
        return pipeline();
      }
    };
  })
  ->in('Feature');
