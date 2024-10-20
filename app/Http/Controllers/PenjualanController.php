<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel; // Model for Penjualan
use App\Models\PenjualanDetailModel; // Model for PenjualanDetail
use App\Models\BarangModel; // Assuming you have a BarangModel
use App\Models\KategoriModel; // Assuming you have a KategoriModel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    public function index()
    {
        $activeMenu = 'penjualan';
        $breadcrumb = (object) [
            'title' => 'Data Penjualan',
            'list' => ['Home', 'Penjualan']
        ];
        return view('penjualan.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function list(Request $request)
    {
        $penjualans = PenjualanModel::with('user', 'pembeli'); // Assuming you have relationships set up

        return DataTables::of($penjualans)
            ->addIndexColumn()
            ->addColumn('aksi', function ($penjualan) {
                $btn = '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $barangs = BarangModel::select('barang_id', 'barang_nama')->get(); // Assuming you want to list barangs
        return view('penjualan.create_ajax', ['barangs' => $barangs]);
    }

    public function storeAjax(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'user_id' => 'required|exists:users,id',  // Assuming you have a users table
        'pembeli' => 'required|string|max:255',
        'penjualan_kode' => 'required|string|max:50|unique:penjualans,penjualan_kode', // Ensure unique kode
        'penjualan_tanggal' => 'required|date',
        'barang_id.*' => 'required|exists:barangs,barang_id', // Validate against barang
        'jumlah.*' => 'required|numeric|min:1',
        'harga_jual.*' => 'required|numeric|min:1',
    ]);

    // Start a transaction
    DB::beginTransaction();

    try {
        // Create a new penjualan (sales) record
        $penjualan = PenjualanModel::create([
            'user_id' => $validatedData['user_id'],
            'pembeli' => $validatedData['pembeli'],
            'penjualan_kode' => $validatedData['penjualan_kode'],
            'penjualan_tanggal' => $validatedData['penjualan_tanggal'],
        ]);

        // Prepare the details to save
        $penjualanDetails = [];
        foreach ($validatedData['barang_id'] as $key => $barangId) {
            $penjualanDetails[] = [
                'penjualan_id' => $penjualan->penjualan_id, // Assuming your penjualan table has penjualan_id as primary key
                'barang_id' => $barangId,
                'jumlah' => $validatedData['jumlah'][$key],
                'harga_jual' => $validatedData['harga_jual'][$key],
                'total_harga' => $validatedData['jumlah'][$key] * $validatedData['harga_jual'][$key],
            ];
        }

        // Insert all details into penjualan_detail table
        PenjualanDetailModel::insert($penjualanDetails);

        // Commit the transaction
        DB::commit();

        return response()->json(['status' => true, 'message' => 'Data penjualan berhasil disimpan.']);
    } catch (\Exception $e) {
        // Rollback the transaction in case of error
        DB::rollBack();

        return response()->json(['status' => false, 'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
    }
}

    public function edit_ajax($id)
    {
        $penjualan = PenjualanModel::find($id);
        return view('penjualan.edit_ajax', ['penjualan' => $penjualan]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'user_id' => ['required', 'integer'],
                'pembeli' => ['required', 'string', 'max:100'],
                'penjualan_kode' => ['required', 'string', 'max:20', 'unique:m_penjualan,penjualan_kode,' . $id . ',penjualan_id'],
                'penjualan_tanggal' => ['required', 'date'],
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }
            $penjualan = PenjualanModel::find($id);
            if ($penjualan) {
                $penjualan->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax($id)
    {
        $penjualan = PenjualanModel::find($id);
        return view('penjualan.confirm_ajax', ['penjualan' => $penjualan]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $penjualan = PenjualanModel::find($id);
            if ($penjualan) {
                $penjualan->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}
