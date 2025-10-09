<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function loginForm() {
        return view('auth.login');
    }

    public function login(Request $req) {
        $credentials = $req->validate([
            'email' => 'string|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)) {
            $req->session()->regenerate();
            return redirect()->intended(route('blog.index'));
        }

        return back()->with('error', 'Invalid Credentials');
    }

    public function registerForm() {
        
        return view('auth.register');
    }

    public function register(Request $req) {
        $user_data = $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $user_data['name'],
            'email' => $user_data['email'],
            'password' => $user_data['password'],
        ]);

        return redirect()->route('login-module')
        ->with('success', 'Register succes pls login to continue using your registered account');
    }

    public function logout(Request $req) {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();

        return redirect()->route('login-module');
    }
}
