@extends('App')
@section('layout')
    <main>
        @yield('content')
    </main>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('static/css/bootstrap-icons.min.css') }}">
@endpush
@push('js')@endpush
