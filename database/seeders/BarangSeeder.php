<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data= [
            [
            'barang_id' => 11,
            'kategori_id' => 01,
            'barang_kode' => 'TOTEBAG1',
            'barang_nama' => 'Tote Bag Puff Cream',
            'harga_beli' => 150000,
            'harga_jual' => 160000
            ],
            [
            'barang_id' => 12,
            'kategori_id' => 02,
            'barang_kode' => 'BACKPACK1',
            'barang_nama' => 'BackPack Puffy Sage',
            'harga_beli' => 155000,
            'harga_jual' => 165000
            ],
            [
            'barang_id' => 13,
            'kategori_id' => 03,
            'barang_kode' => 'SLINGBAG1',
            'barang_nama' => 'Sling Bag Puffy White',
            'harga_beli' => 120000,
            'harga_jual' => 130000
            ],
            [
            'barang_id' => 14,
            'kategori_id' => 04,
            'barang_kode' => 'CLUTCHBAG1',
            'barang_nama' => 'Clutch Bag Puffy Baby Blue',
            'harga_beli' => 110000,
            'harga_jual' => 120000
            ],
            [
            'barang_id' => 15,
            'kategori_id' => 05,
            'barang_kode' => 'VAISTBAG1',
            'barang_nama' => 'Vaist Bag Puffy Cream',
            'harga_beli' => 115000,
            'harga_jual' => 125000
            ],
            [
            'barang_id' => 21,
            'kategori_id' => 01,
            'barang_kode' => 'TOTEBAG2',
            'barang_nama' => 'Tote Bag Kulit Brown',
            'harga_beli' => 160000,
            'harga_jual' => 170000
            ],
            [
            'barang_id' => 22,
            'kategori_id' => 02,
            'barang_kode' => 'BACKPACK2',
            'barang_nama' => 'Back Pack Kulit Black',
            'harga_beli' => 165000,
            'harga_jual' => 175000
            ],
            [
            'barang_id' => 23,
            'kategori_id' => 03,
            'barang_kode' => 'SLINGBAG2',
            'barang_nama' => 'Sling Bag Kulit Brown',
            'harga_beli' => 150000,
            'harga_jual' => 160000
            ],
            [
            'barang_id' => 24,
            'kategori_id' => 04,
            'barang_kode' => 'CLUTCHBAG2',
            'barang_nama' => 'Clutch Bag Kulit Blue',
            'harga_beli' => 110000,
            'harga_jual' => 120000
            ],
            [
            'barang_id' => 25,
            'kategori_id' => 05,
            'barang_kode' => 'VAISTBAG2',
            'barang_nama' => 'Vaist Bag Kulit Brown',
            'harga_beli' => 130000,
            'harga_jual' => 140000
            ],
            [
            'barang_id' => 31,
            'kategori_id' => 01,
            'barang_kode' => 'TOTEBAG3',
            'barang_nama' => 'Tote Bag Canvas Brown',
            'harga_beli' => 80000,
            'harga_jual' => 90000
            ],
            [
            'barang_id' => 32,
            'kategori_id' => 02,
            'barang_kode' => 'BACKPACK3',
            'barang_nama' => 'Back Pack Ceril Blue',
            'harga_beli' => 260000,
            'harga_jual' => 270000
            ],
            [
            'barang_id' => 33,
            'kategori_id' => 03,
            'barang_kode' => 'SLINGBAG3',
            'barang_nama' => 'Sling Bag Canvas Maroon',
            'harga_beli' => 150000,
            'harga_jual' => 160000
            ],
            [
            'barang_id' => 34,
            'kategori_id' => 04,
            'barang_kode' => 'CLUTCHBAG3',
            'barang_nama' => 'Clutch Bag Canvas Blue',
            'harga_beli' => 50000,
            'harga_jual' => 60000
            ],
            [
            'barang_id' => 35,
            'kategori_id' => 05,
            'barang_kode' => 'VAISTBAG3',
            'barang_nama' => 'Vaist Bag Canvas Brown',
            'harga_beli' => 110000,
            'harga_jual' => 120000
            ]
        ];
        //
        DB::table('m_barang')->insert($data);
    }
}
