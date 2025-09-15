<?php

namespace App\Providers;

use App\Models\AppSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Illuminate\Support\Facades\Config;


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

        $setting = AppSetting::first();

        if ($setting) {
            View::share('appSetting', $setting);
    
            Config::set('mail.from.name', $setting->app_name);
        }

        if (config('database.default') === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=ON;');
        }
    }
}
