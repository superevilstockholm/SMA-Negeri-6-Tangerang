@php
    $path = request()->path();
    if ($path === '/') {
        $segments = [];
    } else {
        $segments = request()->segments();
    }
    $url = '';
@endphp
<section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 align-items-center">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                        @foreach ($segments as $segment)
                            @php
                                $url .= '/' . $segment;
                                $label = str($segment)
                                    ->replace('-', ' ')
                                    ->title();
                                $isLast = $loop->last;
                            @endphp
                            @if ($isLast)
                                <li class="breadcrumb-item d-flex align-items-center active" aria-current="page">
                                    {{ $label }}
                                </li>
                            @else
                                <li class="breadcrumb-item d-flex align-items-center">
                                    <a href="{{ url($url) }}">{{ $label }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
