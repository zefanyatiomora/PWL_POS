<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'detail_id' => 1,
                'penjualan_id' => 111,
                'barang_id' => 13,
                'harga' => 130000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 2,
                'penjualan_id' => 111,
                'barang_id' => 22,
                'harga' => 175000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 3,
                'penjualan_id' => 111,
                'barang_id' => 23,
                'harga' => 160000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 4,
                'penjualan_id' => 112,
                'barang_id' => 12,
                'harga' => 165000,
                'jumlah' => 2
            ],
            [
                'detail_id' => 5,
                'penjualan_id' => 112,
                'barang_id' => 31,
                'harga' => 90000,
                'jumlah' => 2
            ],
            [
                'detail_id' => 6,
                'penjualan_id' => 112,
                'barang_id' => 34,
                'harga' => 60000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 7,
                'penjualan_id' => 113,
                'barang_id' => 35,
                'harga' => 120000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 8,
                'penjualan_id' => 113,
                'barang_id' => 14,
                'harga' => 120000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 9,
                'penjualan_id' => 113,
                'barang_id' => 12,
                'harga' => 165000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 10,
                'penjualan_id' => 114,
                'barang_id' => 21,
                'harga' => 170000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 11,
                'penjualan_id' => 114,
                'barang_id' => 23,
                'harga' => 160000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 12,
                'penjualan_id' => 114,
                'barang_id' => 32,
                'harga' => 270000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 13,
                'penjualan_id' => 115,
                'barang_id' => 11,
                'harga' => 160000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 14,
                'penjualan_id' => 115,
                'barang_id' => 32,
                'harga' => 270000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 15,
                'penjualan_id' => 115,
                'barang_id' => 21,
                'harga' => 170000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 16,
                'penjualan_id' => 116,
                'barang_id' => 14,
                'harga' => 120000,
                'jumlah' => 5
            ],
            [
                'detail_id' => 17,
                'penjualan_id' => 116,
                'barang_id' => 21,
                'harga' => 170000,
                'jumlah' => 5
            ],
            [
                'detail_id' => 18,
                'penjualan_id' => 116,
                'barang_id' => 35,
                'harga' => 120000,
                'jumlah' => 5
            ],
            [
                'detail_id' => 19,
                'penjualan_id' => 117,
                'barang_id' => 22,
                'harga' => 175000,
                'jumlah' => 2
            ],
            [
                'detail_id' => 20,
                'penjualan_id' => 117,
                'barang_id' => 31,
                'harga' => 90000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 21,
                'penjualan_id' => 117,
                'barang_id' => 33,
                'harga' => 160000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 22,
                'penjualan_id' => 118,
                'barang_id' => 21,
                'harga' => 170000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 23,
                'penjualan_id' => 118,
                'barang_id' => 24,
                'harga' => 120000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 24,
                'penjualan_id' => 118,
                'barang_id' => 33,
                'harga' => 160000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 25,
                'penjualan_id' => 119,
                'barang_id' => 35,
                'harga' => 120000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 26,
                'penjualan_id' => 119,
                'barang_id' => 12,
                'harga' => 165000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 27,
                'penjualan_id' => 119,
                'barang_id' => 15,
                'harga' => 125000,
                'jumlah' => 1
            ],
            [
                'detail_id' => 28,
                'penjualan_id' => 120,
                'barang_id' => 23,
                'harga' => 160000,
                'jumlah' => 3
            ],
            [
                'detail_id' => 29,
                'penjualan_id' => 120,
                'barang_id' => 24,
                'harga' => 120000,
                'jumlah' => 2
            ],
            [
                'detail_id' => 30,
                'penjualan_id' => 120,
                'barang_id' => 25,
                'harga' => 140000,
                'jumlah' => 1
            ]
            ];
            DB::table('t_penjualan_detail')->insert($data);

        //
    }
}
