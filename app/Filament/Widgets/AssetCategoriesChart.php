<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use Filament\Widgets\ChartWidget;

class AssetCategoriesChart extends ChartWidget
{
    protected static ?string $heading = 'Asset by Category';

    protected function getData(): array
    {
        $data = Asset::selectRaw('category_id, COUNT(*) as total')
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->mapWithKeys(fn($item) => [$item->category->name ?? 'Others' => $item->total]);

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Aset',
                    'data' => array_values($data->toArray()),
                ],
            ],
            'labels' => array_keys($data->toArray()),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
