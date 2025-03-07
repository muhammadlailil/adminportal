<?php

namespace Laililmahfud\Adminportal\Providers;

use Illuminate\Support\ServiceProvider;
use Laililmahfud\Adminportal\Console\Commands\AdminPortalInstalationCommand;
use Laililmahfud\Adminportal\Console\Commands\AdminPortalMigrationCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                AdminPortalInstalationCommand::class,
                AdminPortalMigrationCommand::class
            ]);
        }
    }
}
