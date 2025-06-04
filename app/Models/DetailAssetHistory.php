<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailAssetHistory extends Model
{
    public function detailAsset()
    {
        return $this->belongsTo(Detail_asset::class);
    }
}
