<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('dashboard.' . (auth()->user()?->role?->value ?? 'admin') . '.index') }}" class="b-brand d-flex align-items-center gap-2 fs-3 fw-bold">
                <img height="50" src="{{ asset('static/img/logo-sman6tng.png') }}" alt="Logo {{ config('app.name') }}">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                @foreach ($meta['sidebarItems'] as $key => $item)
                    <li class="pc-item pc-caption">
                        <label>{{ $key }}</label>
                    </li>
                    @foreach ($item as $subItem)
                        <li class="pc-item{{ request()->routeIs($subItem['activePattern']) ? ' active' : '' }}">
                            <a href="{{ route($subItem['route']) }}" class="pc-link">
                                <span class="pc-micon d-inline-flex align-items-center">
                                    <i class="{{ $subItem['icon'] }}"></i>
                                </span>
                                <span class="pc-mtext fw-medium">
                                    {{ $subItem['label'] }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                @endforeach
            </ul>
        </div>
    </div>
</nav>
