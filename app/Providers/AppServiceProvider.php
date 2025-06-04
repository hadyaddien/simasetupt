<?php

namespace App\Providers;

use App\Models\Asset;
use App\Models\Detail_asset;
use App\Observers\AuditableObserver;
use App\Observers\DetailAssetHistoryObserver;
use App\Observers\DetailAssetObserver;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
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
        Detail_asset::observe(DetailAssetHistoryObserver::class);
        // foreach ([Asset::class, Detail_asset::class] as $model) {
        //     $model::observe(AuditableObserver::class);
        // }

        // DetailAssetObserver khusus untuk sinkronisasi quantity
        Detail_asset::observe(DetailAssetObserver::class);

        // Custom CSS Filament
        FilamentAsset::register([
            Css::make('custom-stylesheet', 'css/app/custom-stylesheet.css'),
        ]);
    }
}
