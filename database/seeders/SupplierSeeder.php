<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'supplier_id' => 1,
                'supplier_kode' => 'VENDOR1',
                'supplier_nama' => 'OSCAS INDONESIA',
                'supplier_alamat' => 'Jalan Taman Indah, Blok B2 No. 4A'
            ],
            [
                'supplier_id' => 2,
                'supplier_kode' => 'VENDOR2',
                'supplier_nama' => 'ONBAG',
                'supplier_alamat' => 'Jalan Jati Asih No.110, Bekasi'
            ],
            [
                'supplier_id' => 3, // Changed to ensure uniqueness
                'supplier_kode' => 'VENDOR3',
                'supplier_nama' => 'ADVENTURE',
                'supplier_alamat' => 'Jalan Kapuraya No.13C, Bandung'
            ]
        ];

        DB::table('m_supplier')->insert($data);
    }
}
