<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DetailAssetHistoryResource\Pages;
use App\Filament\Resources\DetailAssetHistoryResource\RelationManagers;
use App\Models\DetailAssetHistory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DetailAssetHistoryResource extends Resource
{
    protected static ?string $model = DetailAssetHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Asset Histories';
    protected static ?string $label = 'Asset Histories';

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();

        if (request()->has('detail_asset_id')) {
            $query->where('detail_asset_id', request()->get('detail_asset_id'));
        }

        return $query;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('detailAsset.code_asset')->label('Code Asset')->searchable(),
                TextColumn::make('event')->label('Event'),
                TextColumn::make('changes')
                    ->label('Changes')
                    ->formatStateUsing(fn($state) => json_decode($state)->message ?? '-')
                    ->wrap(),
                TextColumn::make('created_at')->label('Time')->dateTime('d M Y H:i:s'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
            ])
            ->bulkActions([
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDetailAssetHistories::route('/'),
        ];
    }
}
