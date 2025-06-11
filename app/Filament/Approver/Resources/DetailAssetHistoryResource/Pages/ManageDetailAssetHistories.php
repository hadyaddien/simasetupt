<?php

namespace App\Filament\Approver\Resources\DetailAssetHistoryResource\Pages;

use App\Filament\Approver\Resources\DetailAssetHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDetailAssetHistories extends ManageRecords
{
    protected static string $resource = DetailAssetHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
