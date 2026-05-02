@extends('layouts.dashboard')
@section('title', 'Create Classroom')
@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Create Classroom</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Create a new classroom.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.master-data.classrooms.index') }}"
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
                    <form action="{{ route('dashboard.admin.master-data.classrooms.store') }}" autocomplete="off"
                        method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="floatingInputName"
                                placeholder="Name" autocomplete="off" value="{{ old('name') }}" autofocus>
                            <label for="floatingInputName">Name <span class="text-danger">*</span></label>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select name="homeroom_teacher_id" id="floatingInputHomeroomTeacherId"
                                class="form-select @error('homeroom_teacher_id') is-invalid @enderror">
                                <option value="" {{ old('homeroom_teacher_id') ? '' : 'selected' }}>Without Homeroom Teacher</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('homeroom_teacher_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="floatingInputHomeroomTeacherId">Select Homeroom Teacher</label>
                            @error('homeroom_teacher_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 justify-content-center px-4 rounded-pill">
                                <i class="ti ti-device-floppy me-1"></i> Save Classroom
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
