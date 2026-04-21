@extends('App')
@section('layout')
    @if ($meta['showNavbar'] ?? true)
        <x-navbar></x-navbar>
    @endif
    <main>
        @yield('content')
    </main>
    @if ($meta['showFooter'] ?? true)
        <x-footer></x-footer>
    @endif
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('static/css/bootstrap-icons.min.css') }}">
    <style>
        @media (max-width: 992px) {
            body {
                margin-top: 63px;
            }
        }
    </style>
@endpush
@push('js')@endpush
