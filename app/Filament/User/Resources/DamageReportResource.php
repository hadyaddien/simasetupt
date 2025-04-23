<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\DamageReportResource\Pages;
use App\Filament\User\Resources\DamageReportResource\RelationManagers;
use App\Models\DamageReport;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class DamageReportResource extends Resource
{
    protected static ?string $model = DamageReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('detail_asset_id')
                    ->relationship('detailAsset', 'code_asset')
                    ->label('Asset')
                    ->required()
                    ->default(request()->get('detail_asset_id')),

                FileUpload::make('attachment')
                    ->image()
                    ->imageEditor()
                    ->directory('damage_reports')
                    ->required(),

                TextInput::make('description')
                    ->label('Description')
                    ->required(),

                Hidden::make('user_id')
                    ->formatStateUsing(fn($state) => Auth::id())
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('detailAsset.code_asset')
                    ->label('Code Asset'),

                TextColumn::make('user.name')
                    ->label('Reporter'),

                TextColumn::make('status_report')
                    ->label('Report Status'),

                TextColumn::make('action_taken')
                    ->label('Action Taken'),

                TextColumn::make('created_at')
                    ->label('Reported At')
                    ->dateTime(),

            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([]);
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
        ];
    }
}
