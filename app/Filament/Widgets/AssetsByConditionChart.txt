<?php

namespace App\Filament\Widgets;

use App\Models\Detail_asset;
use Filament\Widgets\ChartWidget;

class AssetsByStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Assets by Status';
    protected static ?int $sort = 3;
    protected function getData(): array
    {
        $options = Detail_asset::getAssetStatusOptions();

        $data = Detail_asset::selectRaw('asset_status, COUNT(*) as total')
            ->groupBy('asset_status')
            ->get()
            ->mapWithKeys(fn($item) => [$options[$item->asset_status] ?? 'Unknown' => $item->total]);

        return [
            'datasets' => [
                ['label' => 'Assets', 'data' => array_values($data->toArray())],
            ],
            'labels' => array_keys($data->toArray()),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
