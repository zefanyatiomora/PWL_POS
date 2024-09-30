<?php
namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

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
  // Ambil data user dalam bentuk json untuk datatables 
public function list(Request $request) 
{ 
$users = UserModel::select('user_id', 'username', 'nama', 'level_id') 
->with('level');
// Filter data user berdasarkan level_id
if ($request->level_id){
$users->where('level_id',$request->level_id);
}
return DataTables::of($users) 
->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
->addColumn('aksi', function ($user) { // menambahkan kolom aksi
    /* $btn = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> '; 
$btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> '; 
$btn .= '<form class="d-inline-block" method="POST" action="'. url('/user/'.$user-
>user_id).'">' 
. csrf_field() . method_field('DELETE') . 
'<button type="submit" class="btn btn-danger btn-sm" onclick="return 
confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';*/
$btn = '<button onclick="modalAction(\''.url('/user/' . $user->user_id . 
'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
$btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . 
'/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
$btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . 
'/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
return $btn; 
}) 
->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
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
public function create_ajax()
{
    $level = LevelModel::select('level_id', 'level_nama')->get();

    return view('user.create_ajax')
        ->with('level', $level);
}
public function store_ajax(Request $request) {
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'level_id' => 'required|integer',
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:6',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        UserModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil disimpan',
        ]);
    }

    redirect('/');
}
// Menampilkan halaman form edit user ajax
public function edit_ajax(string $id)
{
    $user = UserModel::find($id);
    $level = LevelModel::select('level_id', 'level_nama')->get();

    return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
}
public function update_ajax(Request $request, $id) {
    // Check if the request is from AJAX
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'level_id' => 'required|integer',
            'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|max:100',
            'password' => 'nullable|min:6|max:20',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, // JSON response, true: success, false: failure
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors(), // Show which fields have errors
            ]);
        }

        $check = UserModel::find($id);
        if ($check) {
            if (!$request->filled('password')) { // If password is not filled, remove it from the request
                $request->request->remove('password');
            }
            $check->update($request->all());
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

    return redirect('/'); // Ensure this return is outside the if statement
}
}