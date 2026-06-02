<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminInstansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat 1 Super Admin (Bisa melihat semua laporan dari seluruh instansi)
        User::updateOrCreate(
            ['email' => 'superadmin@smartcity.go.id'],
            [
                'name' => 'Super Admin SmartCity',
                'password' => Hash::make('password123'),
                'role' => 'superadmin',
                'instansi' => null,
            ]
        );

        // 2. Daftar 14 Instansi yang kamu miliki
        $daftarInstansi = [
            'DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN',
            'DINAS SOSIAL',
            'DINAS PERHUBUNGAN',
            'SEKRETARIAT DAERAH',
            'SEKRETARIAT DPRD',
            'DINAS PENDIDIKAN',
            'SATUAN POLISI PAMONG PRAJA',
            'DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL',
            'DINAS KESEHATAN',
            'BADAN PENANGGULANGAN BENCANA DAERAH (BPBD)',
            'DINAS PERUMAHAN, KAWASAN PERMUKIMAN DAN PERTANAHAN',
            'DINAS TENAGA KERJA DAN TRANSMIGRASI',
            'DINAS LINGKUNGAN HIDUP DAN KEHUTANAN',
            'RUMAH SAKIT UMUM DAERAH UMAR WIRAHADIKUSUMAH'
        ];

        // 3. Generate Akun Admin otomatis untuk setiap instansi
        foreach ($daftarInstansi as $index => $instansi) {
            // Membuat email dummy berdasarkan nama instansi (contoh: admin1@smartcity.go.id)
            $email = 'admin' . ($index + 1) . '@smartcity.go.id';
            
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => 'Admin ' . ucwords(strtolower($instansi)),
                    'email' => $email,
                    'password' => Hash::make('password123'), // password bawaan untuk testing
                    'role' => 'admin_instansi',
                    'instansi' => $instansi,
                ]
            );
        }
    }
}