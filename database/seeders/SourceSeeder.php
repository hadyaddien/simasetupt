<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Source::insert([
            [
                'source_name' => 'PT Teknologi Hebat',
                'address'     => 'Jl. Mawar No. 10, Bogor',
                'contact'     => '081234567890',
                'email'       => 'contact@teknologihebat.co.id',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'source_name' => 'CV Sumber Makmur',
                'address'     => 'Jl. Kenanga No. 25, Jakarta',
                'contact'     => '082345678901',
                'email'       => 'info@sumbermakmur.id',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'source_name' => 'UD Maju Jaya',
                'address'     => 'Jl. Merdeka No. 5, Bandung',
                'contact'     => '083456789012',
                'email'       => 'majujaya@gmail.com',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'source_name' => 'PT Informa',
                'address'     => 'Jl. Wr Jambu No. 12, Bogor',
                'contact'     => '083162403672',
                'email'       => 'informa@email.com',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
