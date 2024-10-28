<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use App\Models\StokModel;
use App\Models\UserModel;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Database\Seeders\StokSeeder;

class StokController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
           'title' => 'Daftar Stok',
           'list' => ['Home','Stok']
        ];

        $page = (object) [
           'title' => 'Detail transaksi stok.'
        ];

        $activeMenu = 'stok'; //set menu yang sedang aktif

        $supplier = SupplierModel::all(); //mengambil data supplier untuk filtering
        $user = UserModel::all(); //ambil data user untuk filter

        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier,'user' => $user, 'activeMenu' => $activeMenu]);
   }

   public function list(Request $request){
    $stoks = StokModel::select('stock_id', 'supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
        -> with(['supplier', 'barang','user']);


        //set data untuk filtering
    if($request->supplier_id){ //filter supplier
        $stoks->where('supplier_id', $request->supplier_id);
    }

    if ($request->user_id) { //filter penerima
        $stoks->where('user_id', $request->user_id);
    }
    
    return DataTables::of($stoks)
    ->addIndexColumn()  
    ->addColumn('aksi', function ($stok) { 

 $btn = '<button onclick="modalAction(\''.url('/stok/' . $stok->stok_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
 $btn .= '<button onclick="modalAction(\''.url('/stok/' . $stok->stok_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
 $btn .= '<button onclick="modalAction(\''.url('/stok/' . $stok->stok_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';

 return $btn; 
    }) 
    ->rawColumns(['aksi'])
    ->make(true);
}
public function create_ajax()
{
    $supplier = SupplierModel::all();
    $barang = BarangModel::all();

    $breadcrumb = (object) [
        'title' => 'Tambah Stok (AJAX)',
        'list' => ['Home', 'Stok', 'Tambah']
    ];

    return view('stok.create_ajax', compact('supplier', 'barang', 'breadcrumb'));
}    

// Menyimpan data stok baru
public function store_ajax(Request $request)
{
    // Aturan validasi
    $rules = [
        'supplier_id' => 'required|exists:m_supplier,supplier_id',
        'barang_id' => 'required|exists:m_barang,barang_id',
        'stok_tanggal' => 'required|date',
        'stok_jumlah' => 'required|numeric|min:1',
    ];

    // Validasi input
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'msgField' => $validator->errors()
        ]);
    }

    // Menyimpan data barang
    StokModel::create([
        'supplier_id' => $request->supplier_id,
        'barang_id' => $request->barang_id,
        'stok_tanggal' => $request->stok_tanggal,
        'stok_jumlah' => $request->stok_jumlah,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Data stok berhasil disimpan'
    ]);
}

// Menampilkan form untuk mengedit stok
public function edit_ajax(string $id)
{
    $stok = StokModel::with('supplier', 'barang')->find($id);  // Eager loading supplier dan barang

    if (!$stok) {
        return response()->json(['status' => false, 'message' => 'Data stok tidak ditemukan']);
    }

    // Mendapatkan list supplier dan barang
    $supplier = SupplierModel::select('supplier_id', 'supplier_name')->get();
    $barang = BarangModel::select('barang_id', 'barang_nama')->get();

    return view('stok.edit_ajax', ['stok' => $stok, 'supplier' => $supplier, 'barang' => $barang]);
}

// Memperbarui data stok
// Memperbarui data stok
public function update_ajax(Request $request, $id)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'supplier_id' => 'required|exists:m_supplier,supplier_id', // Pastikan supplier_id ada di tabel m_supplier
            'barang_id' => 'required|exists:m_barang,barang_id', // Pastikan barang_id ada di tabel m_barang
            'stok_jumlah' => 'required|integer|min:1',
            'stok_tanggal' => 'required|date',
        ];

        // Validasi input
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msgField' => $validator->errors()
            ]);
        }

        // Cari stok berdasarkan ID
        $stok = StokModel::find($id);
        if (!$stok) {
            return response()->json([
                'status' => false,
                'message' => 'Data stok tidak ditemukan'
            ]);
        }

        // Update data stok
        $stok->update([
            'supplier_id' => $request->supplier_id,
            'barang_id' => $request->barang_id,
            'stok_jumlah' => $request->stok_jumlah,
            'stok_tanggal' => $request->stok_tanggal,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data stok berhasil diperbarui'
        ]);
    }

    return response()->json([
        'status' => false,
        'message' => 'Permintaan tidak valid'
    ]);
}    


public function confirm_ajax(string $id)
{
    // Ambil stok berdasarkan ID
    $stok = StokModel::with('supplier', 'barang')->find($id);

    // Pastikan stok ditemukan
    if (!$stok) {
        return response()->json([
            'status' => false,
            'message' => 'Stok tidak ditemukan.'
        ]);
    }

    // Kirimkan data stok ke view
    return view('stok.confirm_ajax', ['stok' => $stok]);
}

public function delete_ajax(Request $request, $id)
{
    // Cek apakah request dari ajax
    if ($request->ajax() || $request->wantsJson()) {
        $stok = StokModel::find($id);

        if ($stok) {
            $stok->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data stok berhasil dihapus',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data stok tidak ditemukan',
            ]);
        }
    }

    return redirect('/');
}

public function show_ajax($id)
{
    $stok = StokModel::with(['supplier', 'barang'])->find($id);
    $page = (object)[
        'title' => 'Detail Stok'
    ];

    return view('stok.show_ajax', compact('stok', 'page'));
}

public function import_ajax(Request $request)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            // validasi file harus xls atau xlsx, max 1MB
            'file_stok' => ['required', 'mimes:xlsx', 'max:1024']
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }
        $file = $request->file('file_stok'); // ambil file dari request
        $reader = IOFactory::createReader('Xlsx'); // load reader file excel
        $reader->setReadDataOnly(true); // hanya membaca data
        $spreadsheet = $reader->load($file->getRealPath()); // load file excel
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $data = $sheet->toArray(null, false, true, true); // ambil data excel
        $insert = [];
        if (count($data) > 1) { // jika data lebih dari 1 baris
            foreach ($data as $baris => $value) {
                if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                    $insert[] = [
                        'kategori_id' => $value['A'],
                        'stok_kode' => $value['B'],
                        'stok_nama' => $value['C'],
                        'jumlah' => $value['D'],
                        'harga' => $value['E'],
                        'created_at' => now(),
                    ];
                }
            }
            if (count($insert) > 0) {
                // insert data ke database, jika data sudah ada, maka diabaikan
                StokModel::insertOrIgnore($insert);
            }
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diimport'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data yang diimport'
            ]);
        }
    }
    return redirect('/');
}

public function export_excel()
{
    // Ambil data stok yang akan diexport
    $stok = StokModel::select('kategori_id', 'stok_kode', 'stok_nama', 'jumlah', 'harga')
        ->orderBy('kategori_id')
        ->with('kategori')
        ->get();

    // Load library excel
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();  // Ambil sheet yang aktif

    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Kode Stok');
    $sheet->setCellValue('C1', 'Nama Stok');
    $sheet->setCellValue('D1', 'Jumlah');
    $sheet->setCellValue('E1', 'Harga');
    $sheet->setCellValue('F1', 'Kategori');

    $sheet->getStyle('A1:F1')->getFont()->setBold(true); // Bold header

    $no = 1; // Nomor data dimulai dari 1
    $baris = 2; // Baris data dimulai dari baris ke 2

    foreach ($stok as $key => $value) {
        $sheet->setCellValue('A' . $baris, $no); // Perbaiki cara penulisan
        $sheet->setCellValue('B' . $baris, $value->stok_kode);
        $sheet->setCellValue('C' . $baris, $value->stok_nama);
        $sheet->setCellValue('D' . $baris, $value->jumlah);
        $sheet->setCellValue('E' . $baris, $value->harga);
        $sheet->setCellValue('F' . $baris, $value->kategori->kategori_nama); // Ambil nama kategori
        $baris++;
        $no++;
    }

    // Set auto size untuk kolom
    foreach (range('A', 'F') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $sheet->setTitle('Data Stok'); // Set title sheet

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // Pastikan ini sudah di-import
    $filename = 'Data_Stok_' . date('Y-m-d_H-i-s') . '.xlsx'; // Ubah format nama file agar lebih baik

    // Set header untuk download file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 25 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');

    // Simpan ke output
    $writer->save('php://output');
    exit;
}

public function export_pdf(){
    $stok = StokModel::select('stok_id', 'supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah', 'created_at', 'updated_at')
        ->orderBy('stok_tanggal', 'desc')
        ->get();
        
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('stok.export_pdf', ['stok' => $stok]);
    $pdf->setPaper('a4', 'portrait');
    $pdf->setOption('isRemoteEnabled', true);
    $pdf->render();

    return $pdf->stream('Data Stok ' . date('Y-m-d H:i:s') . '.pdf');
}

}
