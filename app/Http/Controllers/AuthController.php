<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('login', 'password');

        if (Auth::attempt($credentials)) {
          return redirect()->route('moonshine.moonShineUsers.index');
        }


        return back()->withErrors(['email' => 'Неверный логин или пароль']);
    }

}
