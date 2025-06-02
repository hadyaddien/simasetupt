<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetResource\Pages;
use App\Filament\Resources\AssetResource\Pages\DetailAsset;
use App\Filament\Resources\AssetResource\RelationManagers;
use App\Filament\Resources\AssetResource\RelationManagers\DetailAssetsRelationManager;
use App\Models\Asset;
use App\Models\Recipient;
use App\Models\User;
use DatePeriod;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssetResource extends Resource
{
    protected static ?string $navigationLabel = 'Manage Data Assets';

    protected static ?string $model = Asset::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Product Information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                FileUpload::make('picture')
                                    ->label('Product Image')
                                    ->image()
                                    ->imageEditor(),

                                TextInput::make('name')
                                    ->label('Product Name')
                                    ->columnSpan(2)
                                    ->required(),
                            ])
                            ->columns(3),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('brand')
                                    ->label('Brand')
                                    ->required(),

                                TextInput::make('specification')
                                    ->label('Model/Type/Specification')
                                    ->required(),

                                Select::make('production_year')
                                    ->label('Production Year')
                                    ->options(
                                        collect(range(date('Y'), 2000))
                                            ->mapWithKeys(fn($year) => [$year => $year])
                                            ->toArray()
                                    )
                                    ->searchable(),
                            ]),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('price')
                                    ->label('Price per Item')
                                    ->required()
                                    ->prefix('Rp.')
                                    ->numeric(),

                                Select::make('unit')
                                    ->label('Unit')
                                    ->options(Asset::getUnitOptions())
                                    ->required(),


                                TextInput::make('quantity')
                                    ->label('Quantity')
                                    ->required()
                                    ->numeric()
                                    ->disabled(fn(?string $context) => $context === 'edit')
                                    ->dehydrated(fn(?string $context) => $context !== 'edit')
                                    ->helperText(
                                        fn(?string $context) => $context === 'edit'
                                            ? 'The asset amount is calculated automatically based on the asset details.'
                                            : 'Masukkan jumlah rencana unit saat pembuatan awal.'
                                    ),
                                // ->disabled(fn(?string $context) => $context === 'edit')
                                // ->helperText(fn(?string $context) => $context === 'edit' ? 'Quantity cannot be changed after creation.' : null),
                            ]),
                        Grid::make(2)
                            ->schema([
                                Select::make('source_id')
                                    ->label('Vendor Asset')
                                    ->relationship('source', 'source_name')
                                    ->createOptionForm([
                                        TextInput::make('source_name')
                                            ->label('Vendor Name')
                                            ->required(),
                                        TextInput::make('address')
                                            ->label('Vendor Address'),
                                        TextInput::make('contact')
                                            ->label('Contact'),
                                        TextInput::make('email')
                                            ->label('Email')
                                            ->unique(ignoreRecord: true)
                                            ->email(),
                                    ])
                                    ->searchable()
                                    ->preload(),

                                Select::make('category_id')
                                    ->label('Asset Category')
                                    ->relationship('category', 'category_name')
                                    ->createOptionForm([
                                        TextInput::make('category_name')
                                            ->label('Category Name')
                                            ->helperText('For Example: ELECTRIC')
                                            ->autocapitalize('words')
                                            ->required(),
                                        TextInput::make('category_slug')
                                            ->label('Category Code')
                                            ->autocapitalize('words')
                                            ->helperText('code in 4 letters only! For Example:ELCT')
                                            ->required(),
                                        TextInput::make('description')
                                            ->label('Description'),
                                    ])
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                            ]),
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('received_date')
                                    ->label('Date Received')
                                    ->maxDate(now())
                                    ->native(false)
                                    ->required(),

                                Select::make('recipient_name')
                                    ->label('Recipient')
                                    ->options(fn() => User::pluck('name', 'name'))
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('picture')
                    ->label('Product Images')
                    ->square()
                    ->size(70)
                    ->placeholder('No image uploaded'),

                TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('quantity')
                    ->label('Quantity')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.category_name')
                    ->label('Category')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),

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
            DetailAssetsRelationManager::class,
        ];
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssets::route('/'),
            'create' => Pages\CreateAsset::route('/create'),
            'edit' => Pages\EditAsset::route('/{record}/edit'),
            'view' => Pages\ViewAsset::route('/{record}'),
        ];
    }
}
