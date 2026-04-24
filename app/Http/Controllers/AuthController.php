<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Types
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

// Requests
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    public function loginView(): View
    {
        return view('pages.auth.login', [
            'meta' => [
                'showNavbar' => false,
                'showFooter' => false,
            ],
        ]);
    }

    public function loginAttempt(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return back()->withErrors('Login failed, invalid email or password')->withInput();
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard.' . $request->user()->role->value . '.index')->with('success', 'Login successful!');
    }

    public function logoutAttempt(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login-view')->with('success', 'Logout successful!');
    }
}
