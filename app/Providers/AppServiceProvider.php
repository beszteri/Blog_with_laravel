<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//ha ezt nem integrálom, hiba lesz a migrációnál 1
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //ha ezt nem integrálom, hiba lesz a migrációnál 2
        Schema::defaultStringLength('191');
    }
}
