<?php

namespace App\Filament\Approver\Widgets;

use App\Models\Maintenance;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MaintenanceApprovalTable extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Maintenance::query()
                    ->whereNull('status_approv')
                    ->with(['damageReport.detailAsset.asset'])
            )
            ->columns([
                TextColumn::make('damageReport.detailAsset.code_asset')->label('Code Asset'),
                TextColumn::make('damageReport.detailAsset.asset.name')->label('Asset Name'),
                TextColumn::make('damageReport.description')->label('Report Description'),
                TextColumn::make('damageReport.status')->label('Damage Status'),
                TextColumn::make('cost')->label('Estimated Cost')->money('IDR'),
            ])
            ->actions([
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->form([
                        \Filament\Forms\Components\Select::make('status_approv')
                            ->label('Approval Type')
                            ->options([
                                'allow_repair' => 'Allow Repair',
                                'allow_replace' => 'Allow Replace',
                                'dispose' => 'Dispose',
                            ])
                            ->required(),
                    ])
                    ->action(function (array $data, Maintenance $record) {
                        $record->update([
                            'status_approv' => $data['status_approv'],
                        ]);
                    }),

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn(Maintenance $record) => $record->delete()),
            ])
            ->emptyStateHeading('No maintenance requests awaiting approval.');
    }
}
