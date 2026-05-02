@extends('layouts.dashboard')
@section('title', 'Create Group')
@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Create Group</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Create a new group.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.gallery.groups.index') }}"
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
                    <form action="{{ route('dashboard.admin.gallery.groups.store') }}" autocomplete="off"
                        method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="floatingInputTitle"
                                placeholder="Title" autocomplete="off" value="{{ old('title') }}" autofocus required>
                            <label for="floatingInputTitle">Title <span class="text-danger">*</span></label>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="floatingInputDescription"
                                placeholder="Description" autocomplete="off" data-lenis-prevent>{{ old('description') }}</textarea>
                            <label for="floatingInputDescription">Description</label>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 justify-content-center px-4 rounded-pill">
                                <i class="ti ti-device-floppy me-1"></i> Save Group
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
