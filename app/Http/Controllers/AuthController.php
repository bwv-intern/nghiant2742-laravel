<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Yaml\Yaml;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            Session::put('user', $user);
        }
        return view('index');
    }

    public function login() {
        return view('auth.login');
    }

    public function handleLogin(LoginRequest $request) {

        $credentials = $request->only('email', 'password');
        $email = $credentials['email'];
        $password = $credentials['password'];

        if (Auth::attempt(['email' => $email, 'password' => $password, 'user_flg' => 0])) {
            return redirect()->intended('admin');
        }

        $yamlPath = file_get_contents('../messages.yaml');
        $yamlContents = Yaml::parse($yamlPath);
        $errorMsg = $yamlContents['errors']['E010'];
        
        return redirect()->back()->withInput(['email' => $email, 'password' => $password])->with('errorMsg', $errorMsg);
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
