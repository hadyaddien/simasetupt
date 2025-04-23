<?php

namespace App\Filament\Resources\AssetResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\AssetResource;

class ViewAsset extends ViewRecord
{
    protected static string $resource = AssetResource::class;

    protected static string $view = 'filament.resources.asset-resource.pages.view-asset';
}
