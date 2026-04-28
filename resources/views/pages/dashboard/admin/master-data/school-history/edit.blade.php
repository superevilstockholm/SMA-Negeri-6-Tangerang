@extends('layouts.dashboard')
@section('title', 'Edit School History')
@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Edit School History</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Update this schoo history.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.master-data.school-histories.index') }}"
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
                    <form action="{{ route('dashboard.admin.master-data.school-histories.update', $schoolHistory->id) }}" autocomplete="off"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-floating mb-3">
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="floatingInputTitle"
                                placeholder="Title" autocomplete="off" value="{{ old('title', $schoolHistory->title) }}" required>
                            <label for="floatingInputTitle">Title</label>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="floatingInputDescription"
                                placeholder="Description" autocomplete="off" required data-lenis-prevent>{{ old('description', $schoolHistory->description) }}</textarea>
                            <label for="floatingInputDescription">Description</label>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="start_year" class="form-control @error('start_year') is-invalid @enderror" id="floatingInputStartYear"
                                placeholder="Start Year" autocomplete="off" value="{{ old('start_year', $schoolHistory->start_year) }}" required>
                            <label for="floatingInputStartYear">Start Year</label>
                            @error('start_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="end_year" class="form-control @error('end_year') is-invalid @enderror" id="floatingInputEndYear"
                                placeholder="End Year" autocomplete="off" value="{{ old('end_year', $schoolHistory->end_year) }}">
                            <label for="floatingInputEndYear">End Year</label>
                            @error('end_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select name="order" id="floatingInputOrder"
                                class="form-select @error('order') is-invalid @enderror" required>
                                <option value="" disabled {{ old('order', $schoolHistory->order) ? '' : 'selected' }}>Select
                                    Order</option>
                                @for ($i = 1; $i <= $allowedMaxOrder; $i++)
                                    <option value="{{ $i }}"
                                        {{ old('order', $schoolHistory->order) == $i ? 'selected' : '' }}>
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
                                <i class="ti ti-device-floppy me-1"></i> Update School History
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
