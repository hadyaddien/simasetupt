<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DamageReport extends Model
{
    use HasFactory;

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function detailAsset()
    {
        return $this->belongsTo(Detail_asset::class);
    }

    public static function getStatusReportOptions(): array
    {
        return [
            'new_report' => 'New Report',
            'reviewed' => 'Reviewed',
            'resolved' => 'Resolved',
        ];
    }

    public static function getActionTakenOptions(): array
    {
        return [
            'pending' => 'Pending',
            'repaired' => 'Repaired',
            'replaced' => 'Replaced',
            'disposed' => 'Disposed',
        ];
    }
}
