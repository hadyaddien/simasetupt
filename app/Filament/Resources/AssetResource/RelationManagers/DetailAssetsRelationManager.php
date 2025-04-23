<?php

namespace App\Filament\Resources\AssetResource\RelationManagers;

use App\Models\Detail_asset;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DetailAssetsRelationManager extends RelationManager
{
    protected static string $relationship = 'detail_assets';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('division_id')
                    ->required()
                    ->relationship('division', 'division_name'),

                Select::make('user_id')
                    ->required()
                    ->relationship('user', 'name'),

                Select::make('condition')
                    ->options(Detail_asset::getConditionOptions())
                    ->required(),

                Select::make('asset_status')
                    ->options(Detail_asset::getAssetStatusOptions())
                    ->required(),

                Select::make('room_id')
                    ->required()
                    ->relationship('room', 'room_name'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('condition')
            ->columns([
                TextColumn::make('code_asset'),

                TextColumn::make('room.room_name')
                    ->placeholder('Not Assigned')
                    ->label('Room'),

                TextColumn::make('division.division_name')
                    ->placeholder('Not Assigned')
                    ->label('Division'),

                TextColumn::make('user.name')
                    ->placeholder('Not Assigned')
                    ->label('User'),

                TextColumn::make('condition')
                    ->placeholder('Not Assigned')
                    ->label('Asset Condition'),

                TextColumn::make('asset_status')
                    ->placeholder('Not Assigned')
                    ->label('Asset Status'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
