<?php

namespace App\Providers;

use App\Models\Asset;
use App\Models\Detail_asset;
use App\Observers\AuditableObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

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
        foreach ([Asset::class, Detail_asset::class] as $model) {
            $model::observe(AuditableObserver::class);
        }
    }
}
