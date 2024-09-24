<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\IgnoreFunctionForCodeCoverage;

class UserController extends Controller
{
    public function index()
{
    $user = UserModel::with('level')->get();
    return view('user', ['data' => $user]);
}
}
