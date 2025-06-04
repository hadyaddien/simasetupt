<?php

namespace App\Filament\Widgets;

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
    protected static ?int $sort = 4;
    protected function getTableQuery(): Builder
    {
        $user = Auth::user();

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

            TextColumn::make('user.name')
                ->label('User')
                ->sortable()
                ->searchable(),

            TextColumn::make('asset.name')
                ->label('Product Name')
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
}