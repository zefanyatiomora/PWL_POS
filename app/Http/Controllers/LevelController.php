<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level']
        ];

        $page = (object) [
            'title' => 'Daftar level yang ada'
        ];

        $activeMenu = 'level';

        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request) {
        $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');

        return DataTables::of($levels)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) {
                $btn = '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create() {
        $breadcrumb = (object) [
            'title' => 'Tambah Level',
            'list' => ['Home', 'Level', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah level baru'
        ];

        $activeMenu = 'level';

        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request) {
        $request->validate([
            'level_kode' => 'required|string|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100',
        ]);

        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama
        ]);

        return redirect('/level')->with('success', 'Data level berhasil disimpan.');
    }

    public function create_ajax()
{
    // Mengembalikan view untuk form level
    return view('level.create_ajax');
}

    public function edit_ajax(string $id)
    {
        // Temukan data level berdasarkan ID
        $level = LevelModel::find($id);

        if (!$level) {
            return response()->json(['status' => false, 'message' => 'Data level tidak ditemukan']);
        }

        return view('level.edit_ajax', ['level' => $level]);
    }

    public function store_ajax(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            // Aturan validasi untuk input level
            $rules = [
                'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
                'level_nama' => 'required|string|max:100',
            ];
    
            // Melakukan validasi
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                // Mengembalikan respon jika validasi gagal
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
    
            // Menyimpan data level
            LevelModel::create([
                'level_kode' => $request->level_kode,
                'level_nama' => $request->level_nama,
            ]);
    
            // Mengembalikan respon sukses
            return response()->json([
                'status' => true,
                'message' => 'Data level berhasil disimpan',
            ]);
        }
    
        return redirect('/');
    }    

    public function update_ajax(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|max:20|unique:m_level,level_kode,' . $id . ',level_id',
                'level_nama' => 'required|string|max:100',
            ];

            // Validasi input
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            $level = LevelModel::find($id);

            if ($level) {
                $level->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        }

        return redirect('/');
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $level = LevelModel::find($id);

            if ($level) {
                $level->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        }

        return redirect('/');
    }

    public function confirm_ajax(string $id)
{
    // Ambil data level berdasarkan ID
    $level = LevelModel::find($id);

    // Jika data level tidak ditemukan, kirimkan respon error
    if (!$level) {
        return response()->json([
            'status' => false,
            'message' => 'Level tidak ditemukan.'
        ]);
    }

    // Kembalikan view konfirmasi penghapusan level
    return view('level.confirm_ajax', ['level' => $level]);
}

public function show_ajax(string $id)
{
    // Ambil data level berdasarkan ID
    $level = LevelModel::find($id);

    // Jika data level tidak ditemukan, kirimkan respon error
    if (!$level) {
        return response()->json([
            'status' => false,
            'message' => 'Level tidak ditemukan.'
        ]);
    }

    // Kembalikan view konfirmasi penghapusan level
    return view('level.show_ajax', ['level' => $level]);
}

public function import()
    {
        return view('level.import'); // Menampilkan form import
    }

public function import_ajax(Request $request)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            // Validasi file harus xlsx, max 1MB
            'file_level' => ['required', 'mimes:xlsx', 'max:1024']
        ];
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $file = $request->file('file_level'); // Ambil file dari request
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx'); // Load reader file excel
        $reader->setReadDataOnly(true); // Hanya membaca data
        $spreadsheet = $reader->load($file->getRealPath()); // Load file excel
        $sheet = $spreadsheet->getActiveSheet(); // Ambil sheet yang aktif
        $data = $sheet->toArray(null, false, true, true); // Ambil data excel
        $insert = [];

        if (count($data) > 1) { // Jika data lebih dari 1 baris
            foreach ($data as $baris => $value) {
                if ($baris > 1) { // Baris ke 1 adalah header, maka lewati
                    $insert[] = [
                        'level_kode' => $value['A'], // Pastikan kolom sesuai dengan file Excel
                        'level_nama' => $value['B'], // Pastikan kolom sesuai dengan file Excel
                        'created_at' => now(),
                    ];
                }
            }

            if (count($insert) > 0) {
                // Insert data ke database, jika data sudah ada, maka diabaikan
                LevelModel::insertOrIgnore($insert);
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


public function export_excel() {
    $level = LevelModel::all();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Nama Level');
    $sheet->getStyle('A1:B1')->getFont()->setBold(true);

    $no = 1;
    $baris = 2;

    foreach ($level as $value) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $value->level_nama);
        $baris++;
        $no++;
    }

    foreach (range('A', 'B') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $sheet->setTitle('Data Level');

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
    $filename = 'Data_Level_' . date('Y-m-d_H-i-s') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 25 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');

    $writer->save('php://output');
    exit;
}

public function export_pdf() {
    $level = LevelModel::all();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('level.export_pdf', ['level' => $level]);
    $pdf->setPaper('a4', 'portrait');
    $pdf->setOption('isRemoteEnabled', true);
    $pdf->render();

    return $pdf->stream('Data Level' . date('Y-m-d H:i:s') . '.pdf');
}

}
