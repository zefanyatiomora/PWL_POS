<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua data dari tabel m_user
        $user = UserModel::where('username', 'manager9')->firstOrFail();

        // Tampilkan data dalam view 'user'
        return view('user', ['data' => $user]);
    }
}
