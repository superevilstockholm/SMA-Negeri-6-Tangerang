@extends('layouts.dashboard')
@section('title', 'Create User')
@section('content')
    @php
        use App\Enums\RoleEnum;
    @endphp
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Create User</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Create a new user.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.master-data.users.index') }}"
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
                    <form action="{{ route('dashboard.admin.master-data.users.store') }}" autocomplete="off"
                        method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="floatingInputEmail"
                                placeholder="Email" autocomplete="off" value="{{ old('email') }}" autofocus required>
                            <label for="floatingInputEmail">Email <span class="text-danger">*</span></label>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="floatingInputPassword"
                                placeholder="Password" autocomplete="off" value="{{ old('password') }}" required>
                            <label for="floatingInputPassword">Password <span class="text-danger">*</span></label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select name="role" id="floatingInputRole" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="" {{ old('role') ? '' : 'selected' }} disabled>
                                    Select Role
                                </option>
                                @foreach (RoleEnum::cases() as $role)
                                    <option value="{{ $role->value }}"
                                        {{ old('role') == $role->value ? 'selected' : '' }}>
                                        {{ ucfirst(strtolower($role->value)) }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="floatingInputRole">Role <span class="text-danger">*</span></label>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="teacherField" class="form-floating mb-3 d-none">
                            <select name="teacher_id" id="floatingInputTeacherId"
                                class="form-select @error('teacher_id') is-invalid @enderror">
                                <option value="" disabled selected>Select Teacher</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}"
                                        {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="floatingInputTeacherId">Teacher <span class="text-danger">*</span></label>
                            @error('teacher_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 justify-content-center px-4 rounded-pill">
                                <i class="ti ti-device-floppy me-1"></i> Save User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    const roleSelect = document.getElementById('floatingInputRole');
    const teacherField = document.getElementById('teacherField');
    const teacherSelect = teacherField.querySelector('select');
    function toggleTeacherField() {
        if (roleSelect.value === '{{ RoleEnum::TEACHER }}') {
            teacherField.classList.remove('d-none');
            if (teacherSelect) teacherSelect.required = true;
        } else {
            teacherField.classList.add('d-none');
            if (teacherSelect) {
                teacherSelect.required = false;
                teacherSelect.value = '';
            }
        }
    }
    toggleTeacherField();
    roleSelect.addEventListener('change', toggleTeacherField);
</script>
@endpush
