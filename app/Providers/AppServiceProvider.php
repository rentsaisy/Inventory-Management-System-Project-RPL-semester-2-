<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\IncomingTransaction;
use App\Models\OutgoingTransaction;
use App\Observers\IncomingTransactionObserver;
use App\Observers\OutgoingTransactionObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the IncomingTransaction observer
        IncomingTransaction::observe(IncomingTransactionObserver::class);
        
        // Register the OutgoingTransaction observer
        OutgoingTransaction::observe(OutgoingTransactionObserver::class);
    }
}
