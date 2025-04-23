<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 4;
    protected static ?string $model = Category::class;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('category_name')
                    ->label('Category')
                    ->required(),

                TextInput::make('category_slug')
                    ->label('Category Code')
                    ->required(),

                Textarea::make('description')
                    ->label('Description')
                    ->autosize(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category_name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category_slug')
                    ->label('Category Code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Description'),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
