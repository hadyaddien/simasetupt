<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use App\Models\Detail_asset;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalAssets extends BaseWidget
{
    protected ?string $heading = 'Overview';
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Assets', Asset::count()),
            Stat::make('Asset In Use', Detail_asset::where('asset_status', 'in_use')->count()),
            Stat::make('Asset In Repair', Detail_asset::where('asset_status', 'in_repair')->count()),
            Stat::make('Asset In Warehouse', Detail_asset::where('asset_status', 'in_warehouse')->count()),

        ];
    }
}
