<?php

namespace App\Providers;

use App\Composers\CartComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Facades\View::composer('client.layouts.app', CartComposer::class);
    }
}
