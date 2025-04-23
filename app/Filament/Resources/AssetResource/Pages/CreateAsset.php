<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use App\Models\Detail_asset;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateAsset extends CreateRecord
{
    protected static string $resource = AssetResource::class;

    protected array $recipientData = [];

    protected function getRedirectUrl(): string
    {
        // return $this->getResource()::getUrl('index');
        $record = $this->record; // akses record yang baru dibuat
        return $this->getResource()::getUrl('edit', ['record' => $record]) . '?activeRelationManager=detail_assets';
    }

    protected function handleRecordCreation(array $data): Model
    {
        try {
            return DB::transaction(function () use ($data) {
                $asset = parent::handleRecordCreation($data);
                $asset->generateDetailAssets();
                return $asset;
            });
        } catch (\Throwable $e) {
            Notification::make()
                ->title('Failed to Save Asset Data')
                ->body($e->getMessage())
                ->danger()
                ->send();
            throw $e;
        }
    }

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Asset successfully added!')
            ->success()
            ->send();
    }
}
