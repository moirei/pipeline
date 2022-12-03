<?php

namespace MOIREI\Pipeline;

use Illuminate\Support\ServiceProvider;

class PipelineServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('pipeline', function ($app) {
            return $app->make(Pipeline::class);
        });
    }

    public function provides(): array
    {
        return [
            Pipeline::class,
        ];
    }
}
