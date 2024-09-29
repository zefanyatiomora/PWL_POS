<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KategoriModel;
use Yajra\DataTables\Facades\DataTables;


class KategoriController extends Controller
{

      public function index() {

        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home','Kategori']
         ];

         $page = (object) [
            'title' => 'Daftar kategori yang ada'
         ];

         $activeMenu = 'kategori'; //set menu yang sedang aktif

         return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request){
        $kategoris = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        
        return DataTables::of($kategoris)
        ->addIndexColumn()  
        ->addColumn('aksi', function ($kategori) { 
            $btn  = '<a href="'.url('/kategori/' . $kategori->kategori_id).'" class="btn btn-info btn-sm">Detail</a> '; 
            $btn .= '<a href="'.url('/kategori/' . $kategori->kategori_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> '; 
            $btn .= '<form class="d-inline-block" method="POST" action="'. url('/kategori/' . $kategori->kategori_id).'">' 
                    . csrf_field() . method_field('DELETE') .  
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';      
            return $btn; 
        }) 
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function create() {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home','Kategori','Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah kategori baru'
        ];

        $activeMenu = 'kategori';

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request) {
        $request -> validate ([
            'kategori_kode'  => 'required|string|unique:m_kategori,kategori_kode',
            'kategori_nama'  => 'required|string|max:100',

        ]);

        KategoriModel::create([
            'kategori_kode'  => $request->kategori_kode,
            'kategori_nama'  => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan.');
    }

    public function show(string $id) {
        $kategori = KategoriModel::find($id);
        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list'  => ['Home','Kategori','Detail']
        ];

        $page = (object) [
            'title' => 'Detail Kategori',
        ];

        $activeMenu = 'kategori';

        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page,'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id) {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home','Kategori','Edit'],
        ];

        $page = (object) [
            'title' => 'Edit Kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'kategori' => $kategori, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id) {
        $request -> validate( [ 
            'kategori_kode'  => 'required|string|unique:m_kategori,kategori_kode',
            'kategori_nama'  => 'required|string|max:100',
        ]);

        kategoriModel::find($id)->update([
            'kategori_kode'  => $request->kategori_kode,
            'kategori_nama'  => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('success','Data kategori berhasil diubah');

    }

    public function destroy(string $id) {
        $check = kategoriModel::find($id);
        if(!$check) {
            return redirect('/kategori') -> with('error', 'Data kategori tidak ditemukan');
        }

        try {
            kategoriModel::destroy($id);

            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori') -> with('error','Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
  }
