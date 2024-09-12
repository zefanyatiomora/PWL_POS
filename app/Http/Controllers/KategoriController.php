<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        // Data yang akan diinsert
        $data = [
            'kategori_kode' => 'SNK',
            'kategori_nama' => 'Snack/Makanan Ringan',
            'created_at' => now(),
        ];

        // Insert data ke tabel m_kategori
     //   DB::table('m_kategori')->insert($data);

        // Tampilkan pesan sukses insert
      //  return 'Insert data baru berhasil';

        // Update data (contoh: mengubah nama kategori dengan kode SNK)
       // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update(['kategori_nama' => 'Camilan']);

        // Tampilkan pesan sukses update beserta jumlah data yang diupdate
        //return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';

       // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->delete();
       // return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row . ' baris';

       $data = DB::table('m_kategori')->get();
       return view('kategori', ['data' => $data]);

    }
}

