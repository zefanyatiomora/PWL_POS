<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori_id' => 01,
                'kategori_kode' => 'JENIS01',
                'kategori_nama' => 'Tote Bag'
            ],
            [
                'kategori_id' => 02,
                'kategori_kode' => 'JENIS02',
                'kategori_nama' => 'BackPack'
            ],
            [
                'kategori_id' => 03,
                'kategori_kode' => 'JENIS03',
                'kategori_nama' => 'Sling Bag'
            ],
            [
                'kategori_id' => 04,
                'kategori_kode' => 'JENIS04',
                'kategori_nama' => 'Clutch Bag'
            ],
            [
                'kategori_id' => 05,
                'kategori_kode' => 'JENIS05',
                'kategori_nama' => 'Vaist Bag'
            ]
            ];
            DB::table('m_kategori')->insert($data);
        //
    }
}
