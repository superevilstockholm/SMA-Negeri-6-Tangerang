@extends('layouts.dashboard')
@section('title', 'Edit Mission')
@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Edit Mission</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Update this mission.</p>
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
                    <form action="{{ route('dashboard.admin.master-data.missions.update', $mission->id) }}" autocomplete="off"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-floating mb-3">
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" id="floatingInputContent"
                                placeholder="Content" autocomplete="off" required>{{ old('content', $mission->content) }}</textarea>
                            <label for="floatingInputContent">Content</label>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select name="order" id="floatingInputOrder"
                                class="form-select @error('order') is-invalid @enderror" required>
                                <option value="" disabled {{ old('order', $mission->order) ? '' : 'selected' }}>Select
                                    Order</option>
                                @for ($i = 1; $i <= $allowedMaxOrder; $i++)
                                    <option value="{{ $i }}"
                                        {{ old('order', $mission->order) == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            <label for="floatingInputOrder">Display Order</label>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 justify-content-center px-4 rounded-pill">
                                <i class="ti ti-device-floppy me-1"></i> Update Mission
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
