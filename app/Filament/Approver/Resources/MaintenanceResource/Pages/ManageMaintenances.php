<?php

namespace App\Filament\Approver\Resources\MaintenanceResource\Pages;

use App\Filament\Approver\Resources\MaintenanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMaintenances extends ManageRecords
{
    protected static string $resource = MaintenanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
