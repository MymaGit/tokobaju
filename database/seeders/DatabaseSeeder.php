<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gavin.test'],
            [
                'name' => 'Admin Gavin',
                'phone' => '081200000001',
                'password' => 'password',
                'role' => User::ROLE_PENJUAL,
            ]
        );

        User::updateOrCreate(
            ['email' => 'annisa.ayu@gmail.com'],
            [
                'name' => 'Annisa Ayu',
                'phone' => '081234567890',
                'password' => 'password',
                'role' => User::ROLE_PELANGGAN,
            ]
        );
    }
}
