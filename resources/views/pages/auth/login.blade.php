@extends('layouts.base')
@section('title', 'Login')
@section('content')
    <section class="vh-100">
        <div class="container-fluid h-100">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="d-none d-lg-block col-lg-8 h-100 ps-0 overflow-hidden">
                    <img class="w-100 h-100 object-fit-cover" src="{{ asset('static/img/login-placeholder.webp') }}" alt="Login Placeholder">
                </div>
                <div class="col-12 col-lg-4 d-flex justify-content-center">
                    <div class="card shadow-none border-0" style="max-width: 350px; background-color: transparent !important;">
                        <div class="card-body">
                            <h1 class="h3 text-center fw-semibold mb-0">WELCOME BACK</h1>
                            <p class="text-muted text-center fw-medium">Login to your account to access your dashboard!</p>
                            <form class="p-0 m-0" action="{{ route('login-attempt') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="mb-2 fw-medium" for="email">Email Address</label>
                                    <div class="input-group input-group-sm">
                                        <input class="form-control" type="text" name="email" id="email" value="{{ old('email') }}" autocomplete="email" autofocus required>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="mb-2 fw-medium" for="password">Password</label>
                                    <div class="input-group input-group-sm">
                                        <input class="form-control" type="password" name="password" id="password" value="{{ old('password') }}" autocomplete="current-password" required>
                                        <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                            <i class="bi bi-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-primary w-100 fw-medium" type="submit">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const icon = togglePassword.querySelector('i');
        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    </script>
@endpush
