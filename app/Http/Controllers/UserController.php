<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Tambah data user dengan Eloquent Model
        $data = [
            'level_id' => 2,
            'username' => 'manager_tiga',
            'nama' => 'Manager 3',
            'password' => Hash::make('12345')
        ];
        
        // Update data user dengan username 'customer-1'
        UserModel::create($data);

        // Ambil semua data dari tabel m_user
        $users = UserModel::all();

        // Tampilkan data dalam view 'user'
        return view('user', ['data' => $users]);
    }
}
