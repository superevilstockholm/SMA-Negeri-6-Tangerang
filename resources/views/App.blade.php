<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Home') - {{ config('app.name') }}</title>
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Host+Grotesk:ital,wght@0,300..800;1,300..800&family=Inter:ital,opsz@0,14..32;1,14..32&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('static/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('static/css/global.css') }}">
    @stack('css')
</head>
<body>
    @yield('layout')
    <x-alerts></x-alerts>
    {{-- JS --}}
    <script src="{{ asset('static/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('static/js/sweetalert2.min.js') }}" defer></script>
    @stack('js')
</body>
</html>
