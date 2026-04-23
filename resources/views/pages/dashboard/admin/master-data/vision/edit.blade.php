@extends('layouts.dashboard')
@section('title', 'Edit Vision')
@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Edit Vision</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Edit a new user account.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.master-data.visions.index') }}"
                            class="btn btn-sm btn-primary px-4 rounded-pill m-0">
                            <i class="ti ti-arrow-left me-1"></i> Back
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
                    <form action="{{ route('dashboard.admin.master-data.visions.update', $vision->id) }}" autocomplete="off" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-floating mb-3">
                            <textarea type="content" name="content" class="form-control @error('content') is-invalid @enderror"
                                id="floatingInputContent" placeholder="Vision Content" value="{{ old('content', $vision->content) }}"
                                autocomplete="off" required>{{ $vision->content }}</textarea>
                            <label for="floatingInputContent">Vision Content</label>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select name="order" id="floatingInputOrder"
                                class="form-select @error('order') is-invalid @enderror" required>
                                <option value="" disabled selected>Choose Order</option>
                                @for ($i = 1; $i <= $allowedMaxOrder; $i++)
                                    <option value="{{ $i }}" {{ old('order', $vision->order) == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            <label for="floatingInputOrder">Vision Order</label>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                <i class="ti ti-device-floppy me-1"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
