<?php
namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    // Menampilkan halaman awal user
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];
    
        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];
    
        $activeMenu = 'user'; // set menu yang sedang aktif
    
        $level = LevelModel::all(); // ambil data level untuk filter level
    
        return view('user.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }
    public function list(Request $request)
{
    // Ambil data pengguna beserta level aksesnya
    $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
        ->with('level')
        ->get(); // Tambahkan get() untuk memeriksa data yang diambil

        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }
    // Konversi data pengguna menjadi format yang sesuai untuk DataTables
    return DataTables::of($users)
        // Tambahkan kolom indeks/no urut
        ->addIndexColumn()
        // Tambahkan kolom aksi dengan tombol detail, edit, dan hapus
        ->addColumn('aksi', function ($user) {
            return '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a>' .
                   '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a>' .
                   '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">' .
                   csrf_field() . method_field('DELETE') .
                   '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
        })
        // Tandai kolom aksi sebagai HTML
        ->rawColumns(['aksi'])
        // Buat objek DataTables
        ->make(true);
}

public function create()
{
    $breadcrumb = (object) [
        'title' => 'Tambah User',
        'list' => ['Home', 'User', 'Tambah']
    ];

    $page = (object) [
        'title' => 'Tambah user baru'
    ];

    $level = LevelModel::all(); // ambil data level untuk ditampilkan di form
    $activeMenu = 'user'; // set menu yang sedang aktif

    return view('user.create', [
        'breadcrumb' => $breadcrumb,
        'page' => $page, // Pastikan ini adalah objek
        'level' => $level,
        'activeMenu' => $activeMenu
    ]);
}


public function store(Request $request) {
    // Validasi data yang dikirimkan dari form
    $request->validate([
        'username' => 'required|string|min:3|unique:m_user,username', // Username harus diisi, minimal 3 karakter, dan unik
        'nama' => 'required|string|max:100', // Nama harus diisi, maksimal 100 karakter
        'password' => 'required|min:5', // Password harus diisi, minimal 5 karakter
        'level_id' => 'required|integer', // Level ID harus diisi dan berupa angka
    ]);

    // Simpan data pengguna ke database
    UserModel::create([
        'username' => $request->username,
        'nama' => $request->nama,
        'password' => bcrypt($request->password), // Enkripsi password sebelum disimpan
        'level_id' => $request->level_id,
    ]);

    // Redirect kembali ke halaman pengguna dengan pesan sukses
    return redirect('/user')->with('success', 'Data user berhasil disimpan');
}
// Menampilkan detail user
public function show(string $id)
{
    $user = UserModel::with('level')->find($id);

    if (!$user) {
        return redirect('/user')->with('error', 'User tidak ditemukan.'); // Redirect with error message if user not found
    }

    $breadcrumb = (object) [
        'title' => 'Detail User',
        'list' => ['Home', 'User', 'Detail'],
    ];

    $page = (object) [
        'title' => 'Detail user',
    ];

    $activeMenu = 'user'; // set menu yang sedang aktif

    return view('user.show', [
        'breadcrumb' => $breadcrumb,
        'page' => $page,
        'user' => $user,
        'activeMenu' => $activeMenu,
    ]);
}
public function edit(string $id)
{
    // Temukan data user berdasarkan ID
    $user = UserModel::find($id);
    // Ambil semua data level
    $level = LevelModel::all();

    // Buat data untuk breadcrumb
    $breadcrumb = (object) [
        'title' => 'Edit User',
        'list' => ['Home', 'User', 'Edit'],
    ];

    // Buat data untuk halaman
    $page = (object) [
        'title' => 'Edit User',
    ];
    // Set menu aktif
    $activeMenu = 'user';
    // Render view dengan data yang telah disiapkan
    return view('user.edit', [
        'breadcrumb' => $breadcrumb,
        'page' => $page,
        'user' => $user,
        'level' => $level,
        'activeMenu' => $activeMenu,
    ]);
}
public function update(Request $request, string $id)
{
    $request->validate([
        'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
        'nama' => 'required|string|max:100',
        'password' => 'nullable|min:5',
        'level_id' => 'required|integer',
    ]);

    UserModel::find($id)->update([
        'username' => $request->username,
        'nama' => $request->nama,
        'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
        'level_id' => $request->level_id,
    ]);

    return redirect('/user')->with('success', 'Data user berhasil diubah');
}
// Menghapus data user
public function destroy(string $id)
{
    // Cari data user berdasarkan ID
    $user = UserModel::find($id);

    // Jika data user tidak ditemukan, tampilkan pesan error
    if (!$user) {
        return redirect('/user')->with('error', 'Data user tidak ditemukan');
    }

    try {
        // Hapus data user
        UserModel::destroy($id);

        // Jika berhasil, tampilkan pesan sukses
        return redirect('/user')->with('success', 'Data user berhasil dihapus');
    } catch (\Illuminate\Database\QueryException $e) {
        // Jika terjadi error saat menghapus, tampilkan pesan error
        return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
    }
}

}