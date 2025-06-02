<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DamageReportResource\Pages;
use App\Filament\Resources\DamageReportResource\RelationManagers;
use App\Models\DamageReport;
use App\Models\Detail_asset;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DamageReportResource extends Resource
{
    protected static ?string $navigationLabel = 'Review Damage Reports';

    protected static ?string $model = DamageReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('attachment')
                    ->label('Evidance')
                    ->imageEditor()
                    ->default(request()->get('attachment')),

                Select::make('detail_asset_id')
                    // ->relationship('detailAsset', 'code_asset')
                    ->options(Detail_asset::pluck('code_asset', 'id'))
                    ->label('Asset')
                    ->disabled(),

                Select::make('user_id')
                    ->options(User::pluck('name', 'id'))
                    ->label('Reporter')
                    ->disabled(),

                TextInput::make('description')
                    ->label('Description')
                    ->readOnly()
                    ->disabled(),

                Select::make('status')
                    ->native(false)
                    ->options(DamageReport::getStatusOptions()),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('detailAsset.code_asset')
                    ->label('Asset Code'),

                TextColumn::make('user.name')
                    ->searchable()
                    ->label('Reporter'),

                TextColumn::make('description')
                    ->label('Description'),

                TextColumn::make('status')
                    ->label('Report Status')
                    ->formatStateUsing(fn($state) => DamageReport::getStatusOptions()[$state] ?? $state),

                TextColumn::make('created_at')
                    ->label('Reported At')
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    ->label('Review'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListDamageReports::route('/'),
            'create' => Pages\CreateDamageReport::route('/create'),
            'edit' => Pages\EditDamageReport::route('/{record}/edit'),
        ];
    }
}
