<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function login()
    {
        return Inertia::render('seller/login');
    }

    public function store(Request $request)
    {
        dd(Auth::guard('seller')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $request->boolean('remember')));
        if (Auth::guard('seller')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $request->boolean('remember'))) {
            return redirect()->route('seller.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email & password.']);
    }

    public function logout()
    {
        Auth::guard('seller')->logout();
        return redirect('seller/login');
    }
}
