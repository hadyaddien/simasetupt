<?php

namespace App\Filament\Resources\DamageReportResource\Pages;

use App\Filament\Resources\DamageReportResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDamageReport extends CreateRecord
{
    protected static string $resource = DamageReportResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function mount(): void
    {
        parent::mount();

        // Ambil dari URL
        $this->form->fill([
            'detail_asset_id' => request()->get('detail_asset_id'),
        ]);
    }
}
