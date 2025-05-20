<?php

namespace App\Filament\Approver\Resources;

use App\Filament\Approver\Resources\MaintenanceResource\Pages;
use App\Filament\Approver\Resources\MaintenanceResource\RelationManagers;
use App\Models\Maintenance;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaintenanceResource extends Resource
{
    protected static ?string $model = Maintenance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('status_approv')
                    ->options([
                        'allow_repair' => 'Allow Reparations',
                        'allow_replace' => 'Allow Replacement',
                        'dispose' => 'Dispose',
                    ])
                    ->required()
                    ->label('Status Approval'),
                // View::make('filament.forms.components.attachment-preview')
                //     ->visible(fn(callable $get) => filled($get('damage_report_id')))
                //     ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('damageReport.detailAsset.code_asset')
                    ->label('Code Asset'),
                ImageColumn::make('damageReport.attachment')
                    ->label('Evidance'),
                TextColumn::make('damageReport.description')
                    ->label('Description'),
                TextColumn::make('cost')
                    ->label('Cost')
                    ->money('IDR'),
                TextColumn::make('status_approv')
                    ->label('Status Approve')
                    ->placeholder('Pending'),
                TextColumn::make('damageReport.action_taken')
                    ->label('Action Taken')
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMaintenances::route('/'),
        ];
    }
}
