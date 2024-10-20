<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\ContentTypes;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade as PDF;

class BarangController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
           'title' => 'Daftar Barang',
           'list' => ['Home','Barang']
        ];

        $page = (object) [
           'title' => 'Daftar barang yang dijual di toko.'
        ];

        $activeMenu = 'barang'; 

        $kategori = KategoriModel::all(); 

        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
   }
   
   public function list(Request $request){
       $barangs = BarangModel::select('barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
           -> with('kategori');

       if($request->kategori_id){
           $barangs->where('kategori_id', $request->kategori_id);
       }
       
       return DataTables::of($barangs)
       ->addIndexColumn()  
       ->addColumn('aksi', function ($barang) { 
        //           $btn  = '<a href="'.url('/barang/' . $barang->barang_id).'" class="btn btn-info btn-sm">Detail</a> '; 
        //          $btn .= '<a href="'.url('/barang/' . $barang->barang_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> '; 
        //         $btn .= '<form class="d-inline-block" method="POST" action="'. url('/barang/'.$barang->barang_id).'">' 
        //                . csrf_field() . method_field('DELETE') .  
            //               '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';      
        $btn = '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
        $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
        $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';

        return $btn; 
        }) 
        ->rawColumns(['aksi'])
        ->make(true);
   }

   public function create() {
       $breadcrumb = (object) [
           'title' => 'Tambah Barang',
           'list' => ['Home','Barang','Tambah']
       ];

       $page = (object) [
           'title' => 'Tambah barang baru'
       ];

       $kategori = KategoriModel::all();
       $activeMenu = 'barang';

       return view('barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
   }

   public function store(Request $request) {
       $request -> validate ([
           'barang_kode'    => 'required|string|min:3|unique:m_barang,barang_kode',
           'kategori_id'    => 'required|integer',
           'barang_nama'    => 'required|string|max:100',
           'harga_beli'     => 'required|integer',
           'harga_jual'     => 'required|integer'
       ]);

       BarangModel::create([
           'barang_kode'    => $request->barang_kode,
           'kategori_id'    => $request->kategori_id,
           'barang_nama'    => $request->barang_nama,
           'harga_beli'     => $request->harga_beli,
           'harga_jual'     => $request->harga_jual
       ]);

       return redirect('/barang')->with('success', 'Data barang berhasil disimpan.');
   }

   public function show(string $id) {
       $barang = BarangModel::with('kategori')->find($id);
       $breadcrumb = (object) [
           'title' => 'Detail Barang',
           'list'  => ['Home','Barang','Detail']
       ];

       $page = (object) [
           'title' => 'Detail Barang',
       ];

       $activeMenu = 'barang';

       return view('barang.show', ['breadcrumb' => $breadcrumb, 'page' => $page,'barang' => $barang, 'activeMenu' => $activeMenu]);
   }

   public function show_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        return view('barang.show_ajax', ['barang' => $barang]);
    }

   public function edit(string $id) {
       $barang = BarangModel::find($id);
       $kategori = KategoriModel::all();

       $breadcrumb = (object) [
           'title' => 'Edit Barang',
           'list' => ['Home','Barang','Edit'],
       ];

       $page = (object) [
           'title' => 'Edit Barang'
       ];

       $activeMenu = 'barang';

       return view('barang.edit', ['breadcrumb' => $breadcrumb, 'kategori' => $kategori, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
   }

   public function update(Request $request, string $id) {
       $request -> validate( [ 
           'barang_kode'    => 'required|string|min:3|unique:m_barang,barang_kode',
           'kategori_id'    => 'required|integer',
           'barang_nama'    => 'required|string|max:100',
           'harga_beli'     => 'required|integer',
           'harga_jual'     => 'required|integer'
       ]);

       BarangModel::find($id)->update([
           'barang_kode'    => $request->barang_kode,
           'kategori_id'    => $request->kategori_id,
           'barang_nama'    => $request->barang_nama,
           'harga_beli'     => $request->harga_beli,
           'harga_jual'     => $request->harga_jual
       ]);

       return redirect('/barang')->with('success','Data barang berhasil diubah');

   }

   public function destroy(string $id) {
       $check = BarangModel::find($id);
       if(!$check) {
           return redirect('/barang') -> with('error', 'Data barang tidak ditemukan');
       }

       try {
           BarangModel::destroy($id);

           return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
       } catch (\Illuminate\Database\QueryException $e) {
           return redirect('/barang') -> with('error','Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
       }
   }

   public function create_ajax()
   {
       $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
   
       $breadcrumb = (object) [
           'title' => 'Tambah Barang (AJAX)',
           'list' => ['Home', 'Barang', 'Tambah']
       ];
   
       return view('barang.create_ajax', compact('kategori', 'breadcrumb'));
   }
   
    

    public function store_ajax(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            // Aturan validasi untuk input barang
            $rules = [
                'kategori_id' => 'required|integer',
                'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
                'barang_nama' => 'required|string|max:100',
                'harga_beli' => 'required|numeric|min:1',
                'harga_jual' => 'required|numeric|min:1',
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
                BarangModel::create([
                'kategori_id' => $request->kategori_id,
                'barang_kode' => $request->barang_kode,
                'barang_nama' => $request->barang_nama,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'Data barang berhasil disimpan',
            ]);
        }
    
        return redirect('/');
    }
    
    public function edit_ajax(string $id)
    {
        $barang = BarangModel::with('kategori')->find($id);  // Eager loading kategori
     
        if (!$barang) {
            return response()->json(['status' => false, 'message' => 'Data barang tidak ditemukan']);
        }
    
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
    
        return view('barang.edit_ajax', ['barang' => $barang, 'kategori' => $kategori]);
    }
    
    public function update_ajax(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => 'required|integer',
                'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode,' . $id . ',barang_id',
                'barang_nama' => 'required|max:100',
                'harga_beli' => 'required|numeric',
                'harga_jual' => 'required|numeric',
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }
    
            $barang = BarangModel::find($id);
    
            if (!$barang) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data barang tidak ditemukan'
                ]);
            }
    
            $barang->update($request->all());
                return response()->json([
                'status' => true,
                'message' => 'Data barang berhasil diupdate'
            ]);
        }
    
        return redirect('/');
    }
          

    public function confirm_ajax(string $id)
    {
        $barang = BarangModel::with('kategori')->find($id);
        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan.'
            ]);
        }

        return view('barang.confirm_ajax', ['barang' => $barang]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $barang = BarangModel::find($id);

            if ($barang) {
                $barang->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data barang berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data barang tidak ditemukan',
                ]);
            }
        }

        return redirect('/');
    }
    
    public function import(){
        return view('barang.import');
    }
        
    public function import_ajax(Request $request){
        if($request->ajax() || $request->wantsJson()){
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_barang' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_barang');
            $reader = IOFactory::createReader('Xlsx'); 
            $reader->setReadDataOnly(true); 
            $spreadsheet = $reader->load($file->getRealPath()); 
            $sheet = $spreadsheet->getActiveSheet(); 
            $data = $sheet->toArray(null, false, true, true); 
            $insert = [];
            if(count($data) > 1){ 
                foreach ($data as $baris => $value) {
                    if($baris > 1){ 
                        $insert[] = [
                        'kategori_id' => $value['A'],
                        'barang_kode' => $value['B'],
                        'barang_nama' => $value['C'],
                        'harga_beli' => $value['D'],
                        'harga_jual' => $value['E'],
                        'created_at' => now(),
                        ];
                    }
                }
                if(count($insert) > 0){
                    BarangModel::insertOrIgnore($insert);
                }
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil diimport'
                    ]);
            }else{
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data yang diimport'
            ]);
            }
        }
        return redirect('/');
    }
        
    public function export_excel(){
        $barang = BarangModel::select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
                    ->orderBy('kategori_id')
                    ->with('kategori')
                    ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); 
        
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Barang');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Harga Beli');
        $sheet->setCellValue('E1', 'Harga Jual');
        $sheet->setCellValue('F1', 'Kategori');
        
        $sheet->getStyle('A1:F1')->getFont()->setBold(true); 
        $no = 1; 
        $baris = 2; 
        
        foreach ($barang as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no); 
            $sheet->setCellValue('B' . $baris, $value->barang_kode);
            $sheet->setCellValue('C' . $baris, $value->barang_nama);
            $sheet->setCellValue('D' . $baris, $value->harga_beli);
            $sheet->setCellValue('E' . $baris, $value->harga_jual);
            $sheet->setCellValue('F' . $baris, $value->kategori->kategori_nama); 
            $baris++;
            $no++;
        }

        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        $sheet->setTitle('Data Barang'); // Set title sheet
        
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // Pastikan ini sudah di-import
        $filename = 'Data_Barang_' . date('Y-m-d_H-i-s') . '.xlsx'; // Ubah format nama file agar lebih baik
        
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

    public function export_pdf(){
        $barang = BarangModel::select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
            ->orderBy('kategori_id')
            ->orderBy('barang_kode')
            ->with('kategori')
            ->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('barang.export_pdf', ['barang' => $barang]);
        $pdf->setPaper('a4', 'portrait'); 
        $pdf->setOption('isRemoteEnabled', true); 
        $pdf->render();

        return $pdf->stream('Data Barang' . date('Y-m-d H:i:s') . '.pdf');
    }
}        
