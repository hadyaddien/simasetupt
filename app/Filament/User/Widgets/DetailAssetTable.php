<?php

namespace App\Filament\User\Widgets;

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
    protected static ?int $sort = 3;
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

            TextColumn::make('user.name')
                ->label('User')
                ->sortable()
                ->searchable(),

            TextColumn::make('room.room_name')
                ->label('Location')
                ->placeholder('-'),

            TextColumn::make('condition')
                ->placeholder('Not Assigned')
                ->formatStateUsing(fn($state) => Detail_asset::getConditionOptions()[$state] ?? $state),

            TextColumn::make('asset_status')
                ->placeholder('Not Assigned')
                ->label('Asset Status')
                ->formatStateUsing(fn($state) => Detail_asset::getAssetStatusOptions()[$state] ?? $state),
        ];
        return $columns;
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('lapor_kerusakan')
                ->label('Report')
                ->url(fn($record) => route('filament.user.resources.damage-reports.create', [
                    'detail_asset_id' => $record->id
                ]))
                ->icon('heroicon-o-exclamation-triangle')
                ->color('#125D72')
                ->visible(function ($record) {
                    // Cek status aset harus dalam kondisi layakAdd commentMore actions
                    $allowedAssetStatus = ['in_warehouse', 'in_use', 'in_loan'];
                    if (!in_array($record->asset_status, $allowedAssetStatus)) {
                        return false;
                    }

                    // Cek apakah ada laporan aktif
                    $disallowedStatuses = [
                        'new_report',
                        'reviewed',
                        'action_proposed',
                        'on_repair',
                        'under_replacement',
                        'disposed',
                    ];

                    return !\App\Models\DamageReport::where('detail_asset_id', $record->id)
                        ->whereIn('status', $disallowedStatuses)
                        ->exists();
                }),
        ];
    }
}
