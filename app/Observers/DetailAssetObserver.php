<?php

namespace App\Observers;

use App\Models\Detail_asset;

class DetailAssetObserver
{
    public function created(Detail_asset $detail): void
    {
        $this->syncQuantity($detail);
    }

    public function saved(Detail_asset $detail): void
    {
        $this->syncQuantity($detail);
    }

    public function deleted(Detail_asset $detail): void
    {
        $this->syncQuantity($detail);
    }

    protected function syncQuantity(Detail_asset $detail): void
    {
        $asset = $detail->asset;

        if ($asset) {
            $asset->quantity = $asset->detail_assets()->count();
            $asset->save();
        }
    }
}
