<?php

namespace Laililmahfud\Adminportal\Providers;

use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            // Register console commands here
        }
    }
}
