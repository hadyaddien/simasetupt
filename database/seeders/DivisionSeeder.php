<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Division::insert([
            ['division_name' => 'Administrasi Umum'],
            ['division_name' => 'Akuntansi Keuangan'],
            ['division_name' => 'Lola Data'],
            ['division_name' => 'K3L'],
        ]);
    }
}
