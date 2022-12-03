<?php

namespace MOIREI\Pipeline;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Helpers
{
    /**
     * If the given value is not an array and not null, wrap it in one.
     * If it's a collection, return all its items.
     *
     * @param  mixed  $value
     * @return array
     */
    public static function wrap($payload): array
    {
        if ($payload instanceof Collection) {
            $payload = $payload->all();
        } else {
            $payload = Arr::wrap($payload);
        }

        return $payload;
    }
}
