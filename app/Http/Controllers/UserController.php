<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\IgnoreFunctionForCodeCoverage;

class UserController extends Controller
{
    // Menampilkan semua user
    public function index(){
        $user = UserModel::all();
        return view('user', ['data' => $user]);
    }

    // Halaman tambah user
    public function tambah(){
        return view('user_tambah');
    }

    // Menyimpan user baru
    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id
        ]);

        return redirect('/user');
    }

    // Halaman edit user
    public function ubah($id){
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }

    // Menyimpan perubahan user
    public function ubah_simpan($id, Request $request) {
        $user = UserModel::find($id);
        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make($request->password);
        $user->level_id = $request->level_id;

        $user->save();

        // Log perubahan jika dibutuhkan
        if ($user->wasChanged(['nama', 'username', 'password'])) {
            // Anda bisa melakukan sesuatu di sini jika perlu
            // Contoh: dd($user->wasChanged(['nama', 'username']));
        }

        return redirect('/user'); // pindahkan ke dalam fungsi
    }

    // Menghapus user
    public function delete($id){
        $user= UserModel::find($id);
        $user->delete();
        return redirect('/user');
    }
}
