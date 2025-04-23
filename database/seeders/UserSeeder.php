<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@email.com',
                'password' => Hash::make('admin'),
                'roles' => 'administrator'
            ],
            [
                'name' => 'User',
                'email' => 'user@email.com',
                'password' => Hash::make('user'),
                'roles' => 'viewer'
            ],
            [
                'name' => 'Approver',
                'email' => 'approver@email.com',
                'password' => Hash::make('approver'),
                'roles' => 'approver',
            ],
        ]);
    }
}
