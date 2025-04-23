<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SourceResource\Pages;
use App\Filament\Resources\SourceResource\RelationManagers;
use App\Models\Source;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SourceResource extends Resource
{
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Vendor';
    protected static ?string $model = Source::class;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('source_name')
                    ->label('Vendor Name')
                    ->required(),

                TextInput::make('address')
                    ->label('Address'),

                TextInput::make('contact')
                    ->label('Contact')
                    ->tel(),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->unique(ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('source_name')
                    ->label('Vendor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('address')
                    ->label('Address'),

                TextColumn::make('contact')
                    ->label('Contact'),

                TextColumn::make('email')
                    ->label('Email'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSources::route('/'),
            'create' => Pages\CreateSource::route('/create'),
            'edit' => Pages\EditSource::route('/{record}/edit'),
        ];
    }
}
