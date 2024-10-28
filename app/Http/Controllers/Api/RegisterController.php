<?php
namespace App\Http\Controllers\Api;

use App\Models\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        // Set validasi
$validator = Validator::make($request->all(), [
    'username' => 'required',
    'nama' => 'required',
    'password' => 'required|min:5|confirmed',
    'level_id' => 'required'
]);

// Jika validasi gagal
if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
}

// Buat user
$user = UserModel::create([
    'username' => $request->username,
    'nama' => $request->nama,
    'password' => bcrypt($request->password),
    'level_id' => $request->level_id
]);

// Return response JSON jika user berhasil dibuat
if ($user) {
    return response()->json([
        'success' => true,
        'user' => $user
    ], 201);
}

// Return response JSON jika proses insert gagal
return response()->json([
    'success' => false
], 409);
    }
}