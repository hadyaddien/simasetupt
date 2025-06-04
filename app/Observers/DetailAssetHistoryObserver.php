<?php

namespace App\Observers;

use App\Models\Detail_asset;
use App\Models\DetailAssetHistory;

class DetailAssetHistoryObserver
{
    public function created(Detail_asset $detail)
    {
        DetailAssetHistory::create([
            'detail_asset_id' => $detail->id,
            'event' => 'created',
            'changes' => json_encode(['message' => 'Asset created.']),
        ]);
    }

    public function updated(Detail_asset $detail)
    {
        if ($detail->wasChanged('room_id')) {
            $oldRoomId = $detail->getOriginal('room_id');
            $newRoom = optional($detail->room)->room_name ?? 'Unknown';

            $oldRoomName = \App\Models\Room::find($oldRoomId)?->room_name ?? 'Unknown';

            DetailAssetHistory::create([
                'detail_asset_id' => $detail->id,
                'event' => 'moved',
                'changes' => json_encode([
                    'from' => $oldRoomName,
                    'to' => $newRoom,
                    'message' => "Moved from {$oldRoomName} to {$newRoom}."
                ]),
            ]);
        }

        // Track division pindah
        if ($detail->wasChanged('division_id')) {
            $oldDivId = $detail->getOriginal('division_id');
            $oldDiv = \App\Models\Division::find($oldDivId)?->division_name ?? 'Unknown';
            $newDiv = optional($detail->division)->division_name ?? 'Unknown';

            DetailAssetHistory::create([
                'detail_asset_id' => $detail->id,
                'event' => 'moved_division',
                'changes' => json_encode([
                    'from' => $oldDiv,
                    'to' => $newDiv,
                    'message' => "Moved division from {$oldDiv} to {$newDiv}.",
                ]),
            ]);
        }

        // Track perubahan kondisi
        if ($detail->wasChanged('condition')) {
            $from = $detail->getOriginal('condition') ?? 'Unknown';
            $to = $detail->condition;

            DetailAssetHistory::create([
                'detail_asset_id' => $detail->id,
                'event' => 'changed_condition',
                'changes' => json_encode([
                    'from' => ucfirst(str_replace('_', ' ', $from)),
                    'to' => ucfirst(str_replace('_', ' ', $to)),
                    'message' => "Condition changed from {$from} to {$to}.",
                ]),
            ]);
        }

        // Track perubahan asset_status
        if ($detail->wasChanged('asset_status')) {
            $from = $detail->getOriginal('asset_status') ?? 'Unknown';
            $to = $detail->asset_status;

            DetailAssetHistory::create([
                'detail_asset_id' => $detail->id,
                'event' => 'changed_status',
                'changes' => json_encode([
                    'from' => ucfirst(str_replace('_', ' ', $from)),
                    'to' => ucfirst(str_replace('_', ' ', $to)),
                    'message' => "Status changed from {$from} to {$to}.",
                ]),
            ]);
        }
    }

    public function deleting(Detail_asset $detail)
    {
        DetailAssetHistory::create([
            'detail_asset_id' => $detail->id,
            'event' => 'deleted',
            'changes' => json_encode(['message' => 'Asset deleted.']),
        ]);
    }
}
