<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $activeMenu = 'dashboard';
        $breadCrumb = (object)[
            'title' => 'Welcome',
            'list' => ['Home', 'Welcome']
        ];
        // Logic untuk halaman utama
        return view('welcome')->with('activeMenu', $activeMenu)->with('breadcrumb', $breadCrumb); // atau view lain yang ingin kamu render
    }
}
