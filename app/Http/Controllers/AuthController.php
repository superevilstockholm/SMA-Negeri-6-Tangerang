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

    public function login_attempt(): RedirectResponse
    {

    }

    public function logout_attempt(Request $request): RedirectResponse
    {

    }
}
