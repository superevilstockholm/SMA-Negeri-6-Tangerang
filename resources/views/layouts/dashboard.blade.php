@extends('App')
@section('layout')
    <x-sidebar :meta="$meta"></x-sidebar>
    <x-topbar></x-topbar>
    <div class="pc-container">
        <div class="pc-content">
            <div class="row mb-4">
                <div class="col">
                    @php
                        $segments = request()->segments();
                        $role = $segments[1] ?? null;
                        $group = $segments[2] ?? null;
                        $page = $segments[3] ?? null;
                        $dashboardRoute = "dashboard.$role.index";
                        $pageRoute = $page ? "dashboard.$role.$group.$page.index" : null;
                    @endphp
                    <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                            {{-- Dashboard --}}
                            <li class="breadcrumb-item">
                                <a href="{{ route($dashboardRoute) }}">Dashboard</a>
                            </li>
                            {{-- Group --}}
                            @if($group)
                                <li class="breadcrumb-item">
                                    {{ ucwords(str_replace('-', ' ', $group)) }}
                                </li>
                            @endif
                            {{-- Page --}}
                            @if($page)
                                <li class="breadcrumb-item active">
                                    {{ ucwords(str_replace('-', ' ', $page)) }}
                                </li>
                            @endif
                        </ol>
                    </nav>
                </div>
            </div>
            @yield('content')
        </div>
    </div>
    <footer class="pc-footer">
        <div class="footer-wrapper container">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <p class="m-0 text-center fw-medium text-muted">
                        Copyright &copy; {{ date('Y') }} <b>{{ config('app.name') }}</b>. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('static/css/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('static/css/berry-style.css') }}">
    <link rel="stylesheet" href="{{ asset('static/css/berry-style-preset.css') }}">
@endpush
@push('js')
    <script src="{{ asset('static/js/popper.min.js') }}"></script>
    <script src="{{ asset('static/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('static/js/feather.min.js') }}"></script>
    <script src="{{ asset('static/js/berry-script.js') }}"></script>
@endpush
