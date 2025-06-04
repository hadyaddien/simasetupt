<?php

namespace App\Filament\User\Widgets;

use App\Models\Asset;
use Filament\Widgets\ChartWidget;

class AssetCategoriesChart extends ChartWidget
{
    protected static ?string $heading = 'Asset by Category';

    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $data = Asset::with('category')
            ->selectRaw('category_id, COUNT(*) as total')
            ->groupBy('category_id')
            ->get()
            ->mapWithKeys(function ($item) {
                $name = optional($item->category)->category_name ?? 'Others';
                return [$name => $item->total];
            });

        return [
            'datasets' => [
                [
                    'label' => 'Assets',
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