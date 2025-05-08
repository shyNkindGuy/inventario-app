<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return auth()->check() 
        ? redirect()->route('home')
        : view('auth.login'); 
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ],[
            'email.required' => 'El email es requerido',
            'password.required' => 'La contraseña es requerida'
        ]);

        if (auth()->attempt($credentials)) {
            return redirect()->intended('ventas');
        }

        return back()->withErrors(['email' => 'Credenciales inválidas', 'password' => 'Credenciales inválidas']);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('login');
    }
}
