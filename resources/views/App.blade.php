<!DOCTYPE html>
<html lang="en">
<head>
    {{-- Theme --}}
    <script>
        function applyTheme(theme) {
            document.documentElement.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme);
        }
        function applyThemeIcon(theme) {
            const icon = document.getElementById('theme-icon');
            if (!icon) return;
            icon.classList.remove('ti-sun', 'ti-moon');
            icon.classList.add(theme === 'light' ? 'ti-sun' : 'ti-moon');
        }
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const theme = (savedTheme === 'dark' || savedTheme === 'light') ? savedTheme : 'light';
            applyTheme(theme);
        })();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Home') - {{ config('app.name') }}</title>
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Host+Grotesk:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('static/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('static/css/custom.css') }}">
    @stack('css')
</head>
<body>
    @yield('layout')
    <x-alerts></x-alerts>
    {{-- JS --}}
    <script src="{{ asset('static/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('static/js/sweetalert2.min.js') }}" defer></script>
    <script src="{{ asset('static/js/lenis.min.js') }}" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const lenis = new Lenis({
                lerp: 0.08,
                smoothWheel: true,
                smoothScroll: true,
            });
            function raf(time) {
                lenis.raf(time);
                requestAnimationFrame(raf);
            }
            requestAnimationFrame(raf);
        });
    </script>
    @stack('js')
    {{-- Custom CSS Handle --}}
    <style>
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 0 transparent inset !important;
            box-shadow: 0 0 0 0 transparent inset !important;
            color: var(--bs-body-color) !important;
        }
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-text-fill-color: var(--bs-body-color) !important;
        }
        .markdown-content * {
            margin-bottom: 0;
        }
    </style>
</body>
</html>
