<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        // Logika untuk menampilkan halaman profil
        return view('profile.index');
    }

    public function upload(Request $request)
    {
        // Logika untuk meng-handle upload file profil
        // Misalnya, validasi file dan penyimpanan
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName);

        return back()->with('success', 'File uploaded successfully');
    }
}
