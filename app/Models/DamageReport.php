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

    public static function getStatusOptions(): array
    {
        return [
            'Report Status' => [
                'new_report' => 'New Report',
                'reviewed' => 'Reviewed',
                'action_proposed' => 'Action Proposed',
            ],
            'In Progress' => [
                'on_repair' => 'Under Repair',
                'under_replacement' => 'Under Replacement',
            ],
            'Resolved' => [
                'repaired' => 'Repaired',
                'replaced' => 'Replaced',
                'disposed' => 'Disposed',
            ],
        ];
    }

    public function isApprovedByValidator(): bool
    {
        return $this->validator_status === 'approved';
    }
}
