<?php

namespace App\Observers;

use App\Models\History;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class AuditableObserver
{
    public function created(Model $model)
    {
        $this->logActivity($model, 'Created');
    }

    public function updated(Model $model)
    {
        $changed = $model->getChanges();
        $original = Arr::only($model->getOriginal(), array_keys($changed));
        $this->logActivity($model, 'Updated', compact('original', 'changed'));
    }

    protected function logActivity(Model $model, string $event, array $data = [])
    {
        $old = $data['original'] ?? [];
        $new = $data['changed']  ?? $model->getAttributes();

        // Buat associative changes:
        $changes = [];
        foreach ($new as $field => $value) {
            $changes[$field] = [
                'old' => $old[$field] ?? null,
                'new' => $value,
            ];
        }

        History::create([
            'log_name'     => $event,
            'subject_type' => get_class($model),
            'subject_id'   => $model->getKey(),
            'properties'   => json_encode(['changes' => $changes]),
        ]);
    }

    public function deleted(Model $model)
    {
        // Untuk model Detail_asset saja
        if ($model instanceof \App\Models\Detail_asset) {
            History::create([
                'log_name'     => 'Deleted',
                'subject_type' => get_class($model),
                'subject_id'   => $model->getKey(),
                'code_asset'   => $model->code_asset,
                'properties'   => json_encode(['changes' => $model->getOriginal()]),
            ]);
        }
    }
}
