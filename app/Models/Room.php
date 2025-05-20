<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public static function getFloorOptions(): array
    {
        return [
            '1' => '1st Floor',
            '2' => '2nd Floor',
        ];
    }
}
