@extends('layouts.dashboard')
@section('title', 'Create Mission')
@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Create Mission</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Create a new mission.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.master-data.missions.index') }}"
                            class="btn btn-sm btn-primary d-flex align-items-center gap-2 justify-content-center px-4 rounded-pill m-0">
                            <i class="ti ti-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card my-0">
                <div class="card-body">
                    <form action="{{ route('dashboard.admin.master-data.missions.store') }}" autocomplete="off"
                        method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" id="floatingInputContent"
                                placeholder="Content" autocomplete="off" autofocus required data-lenis-prevent>{{ old('content') }}</textarea>
                            <label for="floatingInputContent">Content <span class="text-danger">*</span></label>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select name="order" id="floatingInputOrder"
                                class="form-select @error('order') is-invalid @enderror" required>
                                <option value="" disabled {{ old('order') ? '' : 'selected' }}>Select order</option>
                                @for ($i = 1; $i <= $allowedMaxOrder; $i++)
                                    <option value="{{ $i }}" {{ old('order') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            <label for="floatingInputOrder">Display Order <span class="text-danger">*</span></label>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 justify-content-center px-4 rounded-pill">
                                <i class="ti ti-device-floppy me-1"></i> Save Mission
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
