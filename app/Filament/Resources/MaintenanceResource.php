<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaintenanceResource\Pages;
use App\Filament\Resources\MaintenanceResource\RelationManagers;
use App\Models\DamageReport;
use App\Models\Maintenance;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaintenanceResource extends Resource
{

    protected static ?string $navigationGroup = 'Assets Management';
    protected static ?string $navigationLabel = 'Request Maintenance';

    protected static ?int $navigationSort = 3;
    protected static ?string $model = Maintenance::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('damage_report_id')
                    ->label('Asset')
                    ->options(function () {
                        return DamageReport::with('detailAsset')
                            ->get()
                            ->mapWithKeys(function ($report) {
                                return [$report->id => $report->detailAsset->code_asset ?? 'Unknown'];
                            });
                    })
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('repair_cost')
                    ->label('Estimated Repairment Cost')
                    ->prefix('Rp.')
                    ->numeric(),

                TextInput::make('replace_cost')
                    ->label('Estimated Replacement Cost')
                    ->prefix('Rp.')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('damageReport.detailAsset.code_asset')
                    ->searchable()
                    ->label('Code Asset'),
                TextColumn::make('repair_cost')
                    ->label('Estimated Repairment Cost')
                    ->sortable()
                    ->money('IDR'),
                TextColumn::make('replace_cost')
                    ->label('Estimated Replacement Cost')
                    ->sortable()
                    ->money('IDR'),
                TextColumn::make('status_approv')
                    ->label('Status Approve')
                    ->placeholder('Pending')
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMaintenances::route('/'),
            'create' => Pages\CreateMaintenance::route('/create'),
            'edit' => Pages\EditMaintenance::route('/{record}/edit'),
        ];
    }
}
