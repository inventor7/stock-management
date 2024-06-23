<?php

namespace App\Providers;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;


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
        Model::unguard();
       

    }
}
