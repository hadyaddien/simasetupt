<?php

namespace App\Filament\Validator\Resources\DamageReportResource\Pages;

use App\Filament\Validator\Resources\DamageReportResource;
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
