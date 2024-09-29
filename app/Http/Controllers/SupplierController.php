<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\SupplierModel;

class SupplierController extends Controller
{
    public function index() {

        $breadcrumb = (object) [
            'title' => 'Daftar Supplier',
            'list' => ['Home','Supplier']
         ];

         $page = (object) [
            'title' => 'Daftar supplier barang.'
         ];

         $activeMenu = 'supplier'; //set menu yang sedang aktif

         return view('supplier.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request){
        $suppliers = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');

        
        return DataTables::of($suppliers)
        ->addIndexColumn()  
        ->addColumn('aksi', function ($supplier) { 
            $btn  = '<a href="'.url('/supplier/' . $supplier->supplier_id).'" class="btn btn-info btn-sm">Detail</a> '; 
            $btn .= '<a href="'.url('/supplier/' . $supplier->supplier_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> '; 
            $btn .= '<form class="d-inline-block" method="POST" action="'. url('/supplier/'.$supplier->supplier_id).'">' 
                    . csrf_field() . method_field('DELETE') .  
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';      
            return $btn; 
        }) 
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function create() {
        $breadcrumb = (object) [
            'title' => 'Tambah Supplier',
            'list' => ['Home','Supplier','Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah supplier baru'
        ];

        $activeMenu = 'supplier';

        return view('supplier.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request) {
        $request -> validate ([
            'supplier_kode'  => 'required|string|unique:m_supplier,supplier_kode',
            'supplier_nama'  => 'required|string|max:100',
            'supplier_alamat'  => 'required|string|max:100'

        ]);

        SupplierModel::create([
            'supplier_kode'  => $request->supplier_kode,
            'supplier_nama'  => $request->supplier_nama,
            'supplier_alamat'  => $request->supplier_alamat
        ]);

        return redirect('/supplier')->with('success', 'Data supplier berhasil disimpan.');
    }

    public function show(string $id) {
        $supplier = SupplierModel::find($id);
        $breadcrumb = (object) [
            'title' => 'Detail Supplier',
            'list'  => ['Home','Supplier','Detail']
        ];

        $page = (object) [
            'title' => 'Detail Supplier',
        ];

        $activeMenu = 'supplier';

        return view('supplier.show', ['breadcrumb' => $breadcrumb, 'page' => $page,'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id) {
        $supplier = SupplierModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Supplier',
            'list' => ['Home','Supplier','Edit'],
        ];

        $page = (object) [
            'title' => 'Edit Supplier'
        ];

        $activeMenu = 'supplier';

        return view('supplier.edit', ['breadcrumb' => $breadcrumb, 'supplier' => $supplier, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id) {
        $request -> validate( [ 
            'supplier_kode'  => 'required|string|unique:m_supplier,supplier_kode',
            'supplier_nama'  => 'required|string|max:100',
            'supplier_alamat' => 'required|string|max:100'
        ]);

        SupplierModel::find($id)->update([
            'supplier_kode'  => $request->supplier_kode,
            'supplier_nama'  => $request->supplier_nama,
            'supplier_alamat'  => $request->supplier_alamat
        ]);

        return redirect('/supplier')->with('success','Data supplier berhasil diubah');

    }

    public function destroy(string $id) {
        $check = SupplierModel::find($id);
        if(!$check) {
            return redirect('/supplier') -> with('error', 'Data supplier tidak ditemukan');
        }

        try {
            SupplierModel::destroy($id);

            return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/supplier') -> with('error','Data supplier gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
