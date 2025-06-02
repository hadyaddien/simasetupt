<?php

namespace App\Observers;

use App\Models\Detail_asset;

class DetailAssetObserver
{
    public function created(Detail_asset $detail): void
    {
        $this->syncAssetQuantity($detail);
    }

    public function deleted(Detail_asset $detail): void
    {
        $this->syncAssetQuantity($detail);
    }

    protected function syncAssetQuantity(Detail_asset $detail): void
    {
        $asset = $detail->asset;

        if ($asset) {
            $asset->quantity = $asset->detail_assets()->count();
            $asset->save();
        }
    }
}
