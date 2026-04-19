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
    public function login_view(): View
    {
        return view('pages.auth.login');
    }

    public function login_attempt(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return back()->withErrors('Login failed. Invalid email or password')->withInput();
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard.' . $request->user()->role->value . '.index')->with('success', 'Login successful!');
    }

    public function logout_attempt(Request $request): RedirectResponse
    {

    }
}
