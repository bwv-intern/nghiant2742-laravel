<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login() {
        return view('auth.login');
    }

    public function handleLogin(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            Session::put('isLogin', true);
            return redirect()->route('product');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register() {
        return view('auth.register');
    }

    public function handleRegister(Request $request) {

        $newUser = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $newUser['password'] = Hash::make($newUser['password']);

         $user = User::create($newUser);
        
        return redirect()->route('login')->with('email', $user->email);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('home');
    }
}
