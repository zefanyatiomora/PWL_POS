<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'penjualan_id' => 111,
                'user_id' => 3,
                'pembeli' => 'Zefanya Tiomora',
                'penjualan_kode' => 'BUY01',
                'penjualan_tanggal' => '2024-04-10'
            ],
            [
                'penjualan_id' => 112,
                'user_id' => 3,
                'pembeli' => 'Reza Kurniawa',
                'penjualan_kode' => 'BUY02',
                'penjualan_tanggal' => '2024-04-10'
            ],
            [
                'penjualan_id' => 113,
                'user_id' => 3,
                'pembeli' => 'Silmy Maulya',
                'penjualan_kode' => 'BUY03',
                'penjualan_tanggal' => '2024-04-10'
            ],
            [
                'penjualan_id' => 114,
                'user_id' => 3,
                'pembeli' => 'Adelia Syaharani',
                'penjualan_kode' => 'BUY04',
                'penjualan_tanggal' => '2024-04-11'
            ],
            [
                'penjualan_id' => 115,
                'user_id' => 3,
                'pembeli' => 'Kamari',
                'penjualan_kode' => 'BUY05',
                'penjualan_tanggal' => '2024-04-12'
            ],
            [
                'penjualan_id' => 116,
                'user_id' => 3,
                'pembeli' => 'Daiva Divani',
                'penjualan_kode' => 'BUY06',
                'penjualan_tanggal' => '2024-04-12'
            ],
            [
                'penjualan_id' => 117,
                'user_id' => 3,
                'pembeli' => 'Diva Alexandra',
                'penjualan_kode' => 'BUY07',
                'penjualan_tanggal' => '2024-04-13'
            ],
            [
                'penjualan_id' => 118,
                'user_id' => 3,
                'pembeli' => 'Karina',
                'penjualan_kode' => 'BUY08',
                'penjualan_tanggal' => '2024-04-15'
            ],
            [
                'penjualan_id' => 119,
                'user_id' => 3,
                'pembeli' => 'Yesaya Abraham',
                'penjualan_kode' => 'BUY09',
                'penjualan_tanggal' => '2024-04-15'
            ],
            [
                'penjualan_id' => 120,
                'user_id' => 3,
                'pembeli' => 'Pangeran Lantang',
                'penjualan_kode' => 'BUY10',
                'penjualan_tanggal' => '2024-04-17'
            ]
            ];
            DB::table('t_penjualan')->insert($data);

        //
    }
}
