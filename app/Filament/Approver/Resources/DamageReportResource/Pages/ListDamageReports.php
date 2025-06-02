<?php

namespace App\Filament\Approver\Resources\DamageReportResource\Pages;

use App\Filament\Approver\Resources\DamageReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDamageReports extends ListRecords
{
    protected static string $resource = DamageReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
