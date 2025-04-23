<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::insert([
            ['room_name' => 'Ruang SDM & ADM', 'floor' => 1],
            ['room_name' => 'Ruang AKT Keuangan', 'floor' => 1],
            ['room_name' => 'Ruang Sekretariat', 'floor' => 2],
            ['room_name' => 'Ruang K3L', 'floor' => 2],
            ['room_name' => 'Gudang', 'floor' => 1],
            ['room_name' => 'Lobby', 'floor' => 1],
        ]);
    }
}
