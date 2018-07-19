<?php

namespace Cblink\ActiveUser;

use Cblink\ActiveUser\Commands\SyncUserActiveAt;
use Illuminate\Support\ServiceProvider;

class ActiveUserServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            SyncUserActiveAt::class,
        ]);
    }

    public function register()
    {
        $this->publishes([
            __DIR__.'/database/' => database_path(),
        ], 'migrations');
    }
}
