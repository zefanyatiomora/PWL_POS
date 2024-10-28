<?php

namespace App\Http\Controllers;

use App\Models\PenjualanDetailModel; // Model for PenjualanDetail
use App\Models\PenjualanModel; // Model for Penjualan
use App\Models\BarangModel; // Assuming you have a BarangModel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PenjualanDetailController extends Controller
{
    public function index($penjualan_id)
    {
        $activeMenu = 'penjualan_detail';
        $breadcrumb = (object) [
            'title' => 'Detail Penjualan',
            'list' => ['Home', 'Penjualan', 'Detail']
        ];
        return view('penjualan_detail.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'penjualan_id' => $penjualan_id
        ]);
    }

    public function list(Request $request)
    {
        $penjualans = PenjualanModel::with(['user', 'penjualan_detail'])->select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal');
    
        if ($request->customer_name) {
            $penjualans->where('pembeli', 'LIKE', '%' . $request->customer_name . '%');
        }
    
        return DataTables::of($penjualans)
            ->addIndexColumn()
            ->addColumn('jumlah_barang', fn ($penjualan) => $penjualan->penjualan_detail->count())
            ->addColumn('total_harga', function ($penjualan) {
                return number_format($penjualan->penjualan_detail->sum(fn ($detail) => $detail->harga * $detail->jumlah), 0, ',', '.');
            })
            ->addColumn('aksi', function ($penjualan) {
                return '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    
    
    public function create_ajax($penjualan_id)
    {
        $barangs = BarangModel::select('barang_id', 'barang_nama')->get();
        return view('penjualan_detail.create_ajax', [
            'barangs' => $barangs,
            'penjualan_id' => $penjualan_id
        ]);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_id' => ['required', 'integer', 'exists:m_penjualan,id'],
                'barang_id' => ['required', 'integer', 'exists:m_barang,barang_id'],
                'harga' => ['required', 'numeric'],
                'jumlah' => ['required', 'integer'],
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            PenjualanDetailModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function edit_ajax($id)
    {
        $detail = PenjualanDetailModel::find($id);
        $barangs = BarangModel::select('barang_id', 'barang_nama')->get();
        return view('penjualan_detail.edit_ajax', [
            'detail' => $detail,
            'barangs' => $barangs
        ]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id' => ['required', 'integer', 'exists:m_barang,barang_id'],
                'harga' => ['required', 'numeric'],
                'jumlah' => ['required', 'integer'],
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }
            $detail = PenjualanDetailModel::find($id);
            if ($detail) {
                $detail->update($request->all());
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
        $detail = PenjualanDetailModel::find($id);
        return view('penjualan_detail.confirm_ajax', ['detail' => $detail]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $detail = PenjualanDetailModel::find($id);
            if ($detail) {
                $detail->delete();
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
