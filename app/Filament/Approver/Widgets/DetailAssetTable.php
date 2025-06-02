<?php

namespace App\Filament\Approver\Widgets;

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
        return Detail_asset::query()
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
}
