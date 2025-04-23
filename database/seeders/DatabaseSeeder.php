<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            DivisionSeeder::class,
            RoomSeeder::class,
            SourceSeeder::class,
            UserSeeder::class,
            // tambahkan seeder lain jika ada
        ]);
    }
}
