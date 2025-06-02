<?php

namespace App\Filament\Validator\Widgets;

use App\Models\Detail_asset;
use App\Models\User;
use Filament\Tables\Actions\Action;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DetailAssetTable extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        $user = Auth::user();

        return Detail_asset::query()
            ->where('division_id', $user->division_id)
            ->orderBy('created_at', 'desc');
    }


    protected function getTableColumns(): array
    {
        $columns = [
            TextColumn::make('code_asset')
                ->label('Code Asset')
                ->sortable()
                ->searchable(),

            TextColumn::make('asset.name')
                ->label('Product Name')
                ->sortable()
                ->searchable(),

            TextColumn::make('room.room_name')
                ->label('Location')
                ->placeholder('-')
                ->sortable()
                ->searchable(),

            TextColumn::make('condition')
                ->label('Asset Condition')
                ->placeholder('-'),

            TextColumn::make('asset_status')
                ->label('Asset Status'),
        ];
        return $columns;
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('lapor_kerusakan')
                ->label('Report')
                ->url(fn($record) => route('filament.validator.resources.damage-reports.create', [
                    'detail_asset_id' => $record->id
                ]))
                ->icon('heroicon-o-exclamation-triangle')
                ->color('#125D72')
                ->visible(function ($record) {
                    // Cek status aset harus dalam kondisi layak
                    $allowedAssetStatus = ['in_warehouse', 'in_use', 'in_loan'];
                    if (!in_array($record->asset_status, $allowedAssetStatus)) {
                        return false;
                    }
    
                    // Cek apakah ada laporan aktif
                    $disallowedStatuses = [
                        'new_report', 'reviewed', 'action_proposed',
                        'on_repair', 'under_replacement', 'disposed',
                    ];
    
                    return !\App\Models\DamageReport::where('detail_asset_id', $record->id)
                        ->whereIn('status', $disallowedStatuses)
                        ->exists();
                }),
        ];
    }
}
