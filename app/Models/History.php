<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;
use App\Models\Source;
use App\Models\Category;
use App\Models\Room;
use App\Models\Asset;
use App\Models\Division;

class History extends Model
{
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }


    protected function resolveRelationValue(string $field, $value)
    {
        if (! $value) {
            return '';
        }

        // Field-field yang kita support
        return match ($field) {
            'source_id'   => optional(Source::find($value))->source_name,
            'category_id' => optional(Category::find($value))->category_name,
            'room_id'     => optional(Room::find($value))->room_name,
            'asset_id'    => optional(Asset::find($value))->name,
            'division_id' => optional(Division::find($value))->division_name,
            'user_id' => optional(User::find($value))->name,
            'detail_asset_id' => optional(Detail_asset::find($value))->code_asset,
            default       => $value,
        };
    }

    public function getOldValuesAttribute(): string
    {
        if (Str::startsWith($this->log_name, 'Created')) {
            return '-';
        }

        $props = json_decode($this->properties, true)['changes'] ?? [];
        $lines = [];
        $exclude = ['id', 'created_at', 'updated_at'];

        foreach ($props as $field => $vals) {
            if (in_array($field, $exclude, true)) {
                continue;
            }
            // ✅ Tambahan: pastikan bentuk $vals adalah array dengan key 'old'
            if (!is_array($vals) || !array_key_exists('old', $vals)) {
                $old = $this->resolveRelationValue($field, $vals); // fallback 1 level
            } else {
                $oldRaw = $vals['old'];
                $old = $this->resolveRelationValue($field, $oldRaw);
            }

            $lines[] = ucfirst(Str::snake($field, ' ')) . ": " . $old;
        }

        return implode("</br>", $lines);
    }

    public function getNewValuesAttribute(): string
    {
        $props = json_decode($this->properties, true)['changes'] ?? [];
        $lines = [];
        $exclude = ['id', 'created_at', 'updated_at', 'picture'];

        foreach ($props as $field => $vals) {
            if (in_array($field, $exclude, true)) {
                continue;
            }
            if (!is_array($vals) || !array_key_exists('new', $vals)) {
                $new = $this->resolveRelationValue($field, $vals);
            } else {
                $newRaw = $vals['new'];
                $new = $this->resolveRelationValue($field, $newRaw);
            }
    
            $lines[] = ucfirst(Str::snake($field, ' ')) . ": " . $new;
        }

        return implode("</br>", $lines);
    }

    public function getCodeAssetDisplayAttribute(): string
    {
        return $this->subject_type === \App\Models\Detail_asset::class
            ? ($this->subject?->code_asset ?? $this->code_asset ?? '-')
            : '-';
    }
}
