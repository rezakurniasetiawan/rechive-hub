<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {

            return redirect()->route('dashboard');
        } else {
            return view('pages.login');
        }
    }

    public function actionlogin(Request $request)
    {
        $credentials  = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        } else {
            Session::flash('error', 'email atau Password Salah');
            return redirect()->route('login');
        }
    }

    public function actionlogout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
