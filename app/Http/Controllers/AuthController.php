<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login atau redirect jika sudah login
     */
    public function login(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectAfterLogin($request);
        }

        return view('pages.login');
    }

    /**
     * Proses login user
     */
    public function actionlogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Jika login berhasil
            return $this->redirectAfterLogin($request);
        }

        // Jika gagal
        Session::flash('error', 'Email atau password salah.');
        return redirect()->route('login');
    }

    /**
     * Redirect otomatis berdasarkan device
     */
    private function redirectAfterLogin(Request $request)
    {
        // if ($this->isMobile($request)) {
        //     return redirect()->route('transactions');
        // }

        return redirect()->route('dashboard');
    }

    /**
     * Deteksi apakah user login melalui perangkat mobile (Android/iPhone)
     */
    private function isMobile(Request $request): bool
    {
        $agent = strtolower($request->header('User-Agent', ''));
        return str_contains($agent, 'android') || str_contains($agent, 'iphone');
    }

    /**
     * Logout user dan arahkan ke halaman login
     */
    public function actionlogout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
