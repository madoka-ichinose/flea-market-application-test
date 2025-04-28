<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function register(Request $request)
    {
        $user = User::create([
        'email' => $request->email,
        'password' => Hash::make($request->password)
    ]);

        Auth::login($user); 

        return redirect('/mypage/profile'); 
    }
}