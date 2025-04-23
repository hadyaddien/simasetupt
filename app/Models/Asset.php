<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Asset extends Model
{
    use HasFactory;

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function detail_assets()
    {
        return $this->hasMany(Detail_asset::class);
    }

    public function damageReports()
    {
        return $this->hasMany(DamageReport::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }


    public function generateDetailAssets(): void
    {
        $categorySlug = Category::find($this->category_id)?->category_slug ?? 'UNK';
        $category = strtoupper(substr($categorySlug, 0, 4));
        $name = strtoupper(Str::slug($this->name, '-'));

        // Loop untuk membuat detail asset berdasarkan quantity
        for ($i = 1; $i <= $this->quantity; $i++) {
            // Format code_asset menjadi kategori-nama item-penomoran item
            $code = $category . '-' . $name . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);  // Contoh: ELEK-PROJECTOR-001

            // Periksa apakah code_asset sudah ada
            while (Detail_asset::where('code_asset', $code)->exists()) {
                // Jika ada duplikasi, ubah kode (misalnya dengan menambah angka)
                $i++;
                $code = $category . '-' . $name . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);
            }

            // Create detail_asset
            $this->detail_assets()->create([
                'code_asset' => $code,
                'room_id' => null,
                'division_id' => null,
                'condition' => null,
                'asset_status' => null,
            ]);
        }
    }

    public static function getUnitOptions()
    {
        return [
            'pcs' => 'Pcs',
            'unit' => 'Unit',
            'pack' => 'Pack',
            'set' => 'Set',
            'box' => 'Box/Cartons',
        ];
    }
}
