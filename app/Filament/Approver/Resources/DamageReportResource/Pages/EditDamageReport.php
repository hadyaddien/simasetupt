<?php

namespace App\Filament\Approver\Resources\DamageReportResource\Pages;

use App\Filament\Approver\Resources\DamageReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDamageReport extends EditRecord
{
    protected static string $resource = DamageReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
