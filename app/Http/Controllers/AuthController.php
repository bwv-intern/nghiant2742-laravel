<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Utils\MessageUtils;

class AuthController extends Controller
{
    /**
     * Display the admin page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index() {
        if (Auth::check()) {
            $user = Auth::user();
            Session::put('user', $user);
        }
        return view('index');
    }

    /**
     * Display the login form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function login() {
        return view('screens.auth.login');
    }

    /**
     * Handle user login.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleLogin(LoginRequest $request) {

        $credentials = $request->only('email', 'password');
        $email = $credentials['email'];
        $password = $credentials['password'];

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect()->intended('admin');
        }

        // Get error message for error code 'E010'
        $errorMsg = MessageUtils::getMessage('E010');
        
        return redirect()->back()->withInput(['email' => $email, 'password' => $password])->with('errorMsg', $errorMsg);
    }

    /**
     * Log the user out.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
