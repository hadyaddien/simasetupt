<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HistoryResource\Pages;
use App\Filament\Resources\HistoryResource\RelationManagers;
use App\Models\History;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HistoryResource extends Resource
{
    protected static ?string $model = History::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Asset Histories';
    protected static ?string $label = 'Asset Histories';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Waktu aksi
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d M Y H:i:s')
                    ->sortable(),

                TextColumn::make('subject.code_asset')
                    ->label('Code Asset')
                    ->searchable()
                    ->formatStateUsing(fn($state, $record) => $record->code_asset_display),
                // Event (created, updated, dll)
                TextColumn::make('log_name')
                    ->label('Activity')
                    ->searchable(),


                // Old Values
                TextColumn::make('old_values')
                    ->label('Old Value')
                    ->wrap()
                    ->toggleable()
                    ->html(),

                // New Values
                TextColumn::make('new_values')
                    ->label('New Value')
                    ->wrap()
                    ->toggleable()
                    ->html(),

            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageHistories::route('/'),
        ];
    }
}
