<nav class="navbar navbar-expand-lg sticky-top bg-body border-bottom">
    <div class="container">
        <a class="navbar-brand fw-medium py-0 d-md-flex align-items-md-center gap-md-3" href="{{ route('index') }}">
            <img height="47" src="{{ asset('static/img/logo-sman6tng.png') }}" alt="Logo {{ config('app.name') }}">
            <span class="d-none d-md-block">{{ config('app.name') }}</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav fw-medium gap-lg-3 align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link ff-open-sans {{ request()->routeIs('index') ? 'active' : '' }}" aria-current="{{ request()->routeIs('index') ? 'page' : false }}" href="{{ route('index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link ff-open-sans {{ request()->routeIs('teacher-and-staff') ? 'active' : '' }}" aria-current="{{ request()->routeIs('teacher-and-staff') ? 'page' : false }}" href="{{ route('teacher-and-staff') }}">Teacher & Staff</a>
                </li>
                <div class="nav-item d-none d-lg-block">
                    <div class="nav-link">
                        <span class="vr"></span>
                    </div>
                </div>
                <li class="nav-item">
                    <div class="nav-link">
                        <a class="btn btn-sm btn-outline-primary ff-open-sans fw-semibold px-3" href="{{ route('login_view') }}">Log In</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
