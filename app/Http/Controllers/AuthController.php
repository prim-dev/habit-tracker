<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Page
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        return view('auth.register');
    }

    /*
    |--------------------------------------------------------------------------
    | Register User
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/login')
            ->with('success', 'Registration successful!');
    }

    /*
    |--------------------------------------------------------------------------
    | Login Page
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | Login User
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect('/dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}