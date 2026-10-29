<?php

namespace App\Providers;

use App\Models\Shuttle;
use App\Observers\ShuttleObserver;
use App\Support\SafeDownloadExcel;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('excel', function ($app) {
            return new SafeDownloadExcel(
                $app->make(\Maatwebsite\Excel\Writer::class),
                $app->make(\Maatwebsite\Excel\QueuedWriter::class),
                $app->make(\Maatwebsite\Excel\Reader::class),
                $app->make(\Maatwebsite\Excel\Files\Filesystem::class)
            );
        });

        // A mail server timeout must not break the user's action (see ResilientMailChannel)
        $this->app->bind(
            \Illuminate\Notifications\Channels\MailChannel::class,
            \App\Notifications\Channels\ResilientMailChannel::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Shuttle::observe(ShuttleObserver::class);
    }
}
