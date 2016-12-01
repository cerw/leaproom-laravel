<?php

namespace App\Providers;

use App\Events\PhoneAdded;
use App\Phone;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Phone::created(function ($phone) {
            event(new PhoneAdded($phone));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
