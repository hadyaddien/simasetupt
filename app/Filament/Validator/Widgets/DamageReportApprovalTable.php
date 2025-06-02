<?php

namespace App\Filament\Validator\Widgets;

use App\Models\DamageReport;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DamageReportApprovalTable extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return DamageReport::query()
            ->where('validator_status', 'pending')
            ->whereHas('detailAsset', fn($q) =>
                $q->where('division_id', Auth::user()->division_id)
            );
    }

    protected function getTableColumns(): array
    {
        return [
            ImageColumn::make('attachment')
            ->label('Evidence')
            ->height(60)
            ->width(60)
            ->square()
            ->extraImgAttributes(['style' => 'object-fit: cover;'])
            ->url(fn($record) => Storage::url($record->attachment))
            ->openUrlInNewTab(), // bisa diklik untuk lihat lebih besar
            TextColumn::make('detailAsset.code_asset')->label('Asset Code'),
            TextColumn::make('user.name')->label('Reporter'),
            TextColumn::make('status')->label('Report Status'),
            TextColumn::make('created_at')->label('Reported At')->dateTime(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('Approve')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->action(fn(DamageReport $record) => $this->updateStatus($record, 'approved')),

            Action::make('Reject')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->action(fn(DamageReport $record) => $this->updateStatus($record, 'rejected')),
        ];
    }

    protected function updateStatus(DamageReport $record, string $status): void
    {
        $record->update(['validator_status' => $status]);

        Notification::make()
            ->title("Report {$status}")
            ->success()
            ->send();
    }
}