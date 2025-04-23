<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Maintenance extends Model
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
    public function damageReport()
    {
        return $this->belongsTo(DamageReport::class);
    }
}
