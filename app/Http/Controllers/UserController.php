<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Tambah data user dengan Eloquent Model
        $data = [
            'nama' => 'Pelanggan Pertama',
        ];
        
        // Update data user dengan username 'customer-1'
        UserModel::where('username', 'customer-1')->update($data);

        // Ambil semua data dari tabel m_user
        $users = UserModel::all();

        // Tampilkan data dalam view 'user'
        return view('user', ['data' => $users]);
    }
}
