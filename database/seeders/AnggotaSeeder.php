<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('anggotas')->insert([
            [
                'nis' => '2024001',
                'nama' => 'Ahmad Fauzi',
                'kelas' => 'XII RPL 1',
                'email' => 'ahmad@perpus.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis' => '2024002',
                'nama' => 'Siti Nurhaliza',
                'kelas' => 'XII RPL 2',
                'email' => 'siti@perpus.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis' => '2024003',
                'nama' => 'Budi Santoso',
                'kelas' => 'XI TKJ 1',
                'email' => 'budi@perpus.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis' => '2024004',
                'nama' => 'Dewi Lestari',
                'kelas' => 'XI MM 1',
                'email' => 'dewi@perpus.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis' => '2024005',
                'nama' => 'Admin Perpustakaan',
                'kelas' => 'ADMIN',
                'email' => 'admin@perpus.com',
                'password' => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
