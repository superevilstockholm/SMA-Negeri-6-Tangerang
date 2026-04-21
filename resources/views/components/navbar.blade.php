<nav class="navbar navbar-expand-lg bg-primary-dark fixed-top sticky-lg-top" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand fw-medium py-0" href="{{ route('index') }}">
            <img height="47" src="{{ asset('static/img/logo-sman6tng.png') }}" alt="Logo {{ config('app.name') }}">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav fw-medium gap-lg-3 align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}" aria-current="{{ request()->routeIs('index') ? 'page' : false }}" href="{{ route('index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" aria-current="{{ request()->routeIs('about') ? 'page' : false }}" href="{{ route('about') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('teacher-and-staff') ? 'active' : '' }}" aria-current="{{ request()->routeIs('teacher-and-staff') ? 'page' : false }}" href="{{ route('teacher-and-staff') }}">Teacher & Staff</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" href="#">
                        Student Life
                        <i class="bi bi-chevron-down fs-09"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark bg-primary-dark border-0 pt-0 pb-2 pb-lg-3 student-life-dropdown rounded-top-0">
                        <li><a class="dropdown-item px-lg-4 py-lg-2" href="{{ route('extracurricular') }}">Extracurricular</a></li>
                        <li><a class="dropdown-item px-lg-4 py-lg-2" href="#">Recognition & Awards</a></li>
                        <li><a class="dropdown-item px-lg-4 py-lg-2" href="#">Stories of Impact</a></li>
                    </ul>
                </li>
                <div class="nav-item d-none d-lg-block">
                    <div class="nav-link">
                        <span class="vr opacity-100"></span>
                    </div>
                </div>
                <li class="nav-item">
                    <div class="nav-link">
                        <a class="btn btn-sm btn-light fw-semibold px-3 d-inline-flex align-items-center gap-2 text-primary-dark contact-us-btn" href="{{ route('contact-us') }}">
                            Contact Us
                            <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
@push('css')
    <style>
        .navbar {
            transition: transform 0.3s ease, opacity 0.2s ease;
            will-change: transform;
        }
        .navbar--hidden {
            transform: translateY(-100%);
        }
        .navbar--visible {
            transform: translateY(0);
        }
        @media (min-width: 992px) {
            .student-life-dropdown {
                padding-top: 11.5px !important;
                margin-top: 0 !important;
            }
        }
        .nav-item .dropdown-menu .dropdown-item {
            transition: all 0.2s ease-in-out;
        }
        .nav-item .dropdown-menu .dropdown-item:hover {
            background-color: transparent;
            transform: translateX(10px);
        }
        .dropdown-toggle::after {
            display: none;
        }
        .contact-us-btn i {
            transition: all 0.2s ease-in-out;
        }
        .contact-us-btn:hover i {
            transform: translateX(5px);
        }
    </style>
@endpush
@push('js')
    <script>
        let lastScrollY = window.scrollY;
        const navbar = document.querySelector('.navbar');
        const collapseEl = document.querySelector('#navbarNav');
        const threshold = 6;
        let ticking = false;
        window.addEventListener('scroll', () => {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(() => {
                const isMenuOpen = collapseEl?.classList.contains('show');
                const hasOpenDropdown = document.querySelector('.navbar .dropdown-menu.show');
                if (isMenuOpen || hasOpenDropdown) {
                    navbar.classList.remove('navbar--hidden');
                    navbar.classList.add('navbar--visible');
                    lastScrollY = window.scrollY;
                    ticking = false;
                    return;
                }
                const currentScrollY = window.scrollY;
                if (currentScrollY > lastScrollY && currentScrollY > 80) {
                    navbar.classList.add('navbar--hidden');
                    navbar.classList.remove('navbar--visible');
                }
                else if (currentScrollY < lastScrollY - threshold) {
                    navbar.classList.remove('navbar--hidden');
                    navbar.classList.add('navbar--visible');
                }
                lastScrollY = currentScrollY;
                ticking = false;
            });
        });
        if (collapseEl) {
            collapseEl.addEventListener('hidden.bs.collapse', () => {
                lastScrollY = window.scrollY;
                navbar.classList.remove('navbar--hidden');
                navbar.classList.add('navbar--visible');
            });
        }
    </script>
@endpush
