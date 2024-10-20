<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Logic untuk halaman utama
        return view('welcome'); // atau view lain yang ingin kamu render
    }
}
