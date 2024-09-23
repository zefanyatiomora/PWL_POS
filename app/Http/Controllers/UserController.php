<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Ambil jumlah data dari tabel m_user berdasarkan level_id
        $userCount = UserModel::where('level_id', 2)->count();
        
        // Tampilkan data dalam view 'user' dengan variabel 'data'
        return view('user', ['data' => $userCount]);
    }
}
