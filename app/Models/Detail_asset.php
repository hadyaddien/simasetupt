<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_asset extends Model
{
    use HasFactory;

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function getConditionOptions(): array
    {
        return [
            'good' => 'Good',
            'minor_damage' => 'Minor Damage',
            'not_functional' => 'Not Functional',
        ];
    }

    public static function getAssetStatusOptions(): array
    {
        return [
            'in_warehouse' => 'In Warehouse',
            'in_use' => 'In Use',
            'in_loan' => 'In Loan',
            'in_repair' => 'In Repair',
            'disposed' => 'Disposed',
        ];
    }
}
