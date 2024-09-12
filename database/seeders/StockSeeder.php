<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'stock_id'=> 101,
                'supplier_id' => 1,
                'barang_id' => 11,
                'user_id' => 2,
                'stok_tanggal' => '2024-03-14',
                'stok_jumlah' => 60
            ],
            [
                'stock_id'=> 102,
                'supplier_id' => 1,
                'barang_id' => 12,
                'user_id' => 2,
                'stok_tanggal' => '2024-03-14',
                'stok_jumlah' => 65
            ],
            [
                'stock_id'=> 103,
                'supplier_id' => 1,
                'barang_id' => 13,
                'user_id' => 2,
                'stok_tanggal' => '2024-03-14',
                'stok_jumlah' => 65
            ],
            [
                'stock_id'=> 104,
                'supplier_id' => 1,
                'barang_id' => 14,
                'user_id' => 2,
                'stok_tanggal' => '2024-03-14',
                'stok_jumlah' => 65
            ],
            [
                'stock_id'=> 105,
                'supplier_id' => 1,
                'barang_id' => 15,
                'user_id' => 2,
                'stok_tanggal' => '2024-03-14',
                'stok_jumlah' => 65
            ],
            [
                'stock_id'=> 201,
                'supplier_id' => 2,
                'barang_id' => 21,
                'user_id' => 2,
                'stok_tanggal' => '2024-03-14',
                'stok_jumlah' => 65
            ],
            [
                'stock_id'=> 202,
                'supplier_id' => 2,
                'barang_id' => 22,
                'user_id' => 2,
                'stok_tanggal' => '2024-03-14',
                'stok_jumlah' => 65
            ],
            [
                'stock_id'=> 203,
                'supplier_id' => 2,
                'barang_id' => 23,
                'user_id' => 2,
                'stok_tanggal' => '2024-03-14',
                'stok_jumlah' => 65
            ],
            [
                'stock_id'=> 204,
                'supplier_id' => 2,
                'barang_id' => 24,
                'user_id' => 2,
                'stok_tanggal' => '2024-03-14',
                'stok_jumlah' => 65
            ],
            [
                'stock_id'=> 205,
                'supplier_id' => 2,
                'barang_id' => 25,
                'user_id' => 2,
                'stok_tanggal' => '2024-03-14',
                'stok_jumlah' => 65
            ],
            [
                'stock_id'=> 301,
                'supplier_id' => 3,
                'barang_id' => 31,
                'user_id' => 2,
                'stok_tanggal' => '2024-03-14',
                'stok_jumlah' => 65
            ],
            [
                'stock_id'=> 302,
                'supplier_id' => 3,
                'barang_id' => 32,
                'user_id' => 2,
                'stok_tanggal' => '2024-03-14',
                'stok_jumlah' => 65
            ],
            [
                'stock_id'=> 303,
                'supplier_id' => 3,
                'barang_id' => 33,
                'user_id' => 2,
                'stok_tanggal' => '2024-03-14',
                'stok_jumlah' => 65
            ],
            [
                'stock_id'=> 304,
                'supplier_id' => 3,
                'barang_id' => 34,
                'user_id' => 2,
                'stok_tanggal' => '2024-03-14',
                'stok_jumlah' => 65
            ],
            [
                'stock_id'=> 305,
                'supplier_id' => 3,
                'barang_id' => 35,
                'user_id' => 2,
                'stok_tanggal' => '2024-03-14',
                'stok_jumlah' => 65
            ]
            ];
            DB::table('t_stock')->insert($data);

        //
    }
}
