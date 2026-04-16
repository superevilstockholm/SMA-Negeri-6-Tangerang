<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Home') - {{ config('app.name') }}</title>
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('static/css/bootstrap.min.css') }}">
    @stack('css')
</head>
<body>
    @yield('layout')
    {{-- JS --}}
    <script src="{{ asset('static/js/bootstrap.bundle.min.js') }}" defer></script>
    @stack('js')
</body>
</html>
