<?php

namespace Cblink\ActiveUser;

use Cblink\ActiveUser\Commands\RecordUserActiveLog;
use Cblink\ActiveUser\Commands\SyncUserActiveAt;
use Illuminate\Support\ServiceProvider;

class ActiveUserServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            SyncUserActiveAt::class,
            RecordUserActiveLog::class,
        ]);
    }

    public function register()
    {
        $this->publishes([
            __DIR__.'/database/' => database_path(),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/stubs/Models' => app_path('Models'),
        ], 'models');
    }
}
