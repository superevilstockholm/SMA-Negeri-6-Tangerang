@extends('layouts.dashboard')
@section('title', 'Create Teacher')
@section('content')
    @php
        use App\Enums\GenderEnum;
    @endphp
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Create Teacher</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Create a new teacher.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.master-data.teachers.index') }}"
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
                    <form action="{{ route('dashboard.admin.master-data.teachers.store') }}" autocomplete="off"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="file" name="photo_file" id="imageInput" class="d-none @error('photo_file') is-invalid @enderror" accept="image/*">
                            <img src="{{ asset('static/img/no-image-placeholder.svg') }}" id="imagePreview" alt="Preview Teacher" class="rounded object-fit-cover border" style="width: 200px; height: 200px; object-position: center; cursor: pointer;">
                            <div class="mt-2 text-muted small">
                                Click on the image to choose file
                            </div>
                            <button type="button" id="removeImageBtn" class="btn btn-sm btn-danger mt-2 d-none">
                                <i class="ti ti-trash me-1"></i> Remove Photo
                            </button>
                            @error('photo_file')
                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="floatingInputName"
                                placeholder="Name" autocomplete="off" value="{{ old('name') }}" required autofocus>
                            <label for="floatingInputName">Name <span class="text-danger">*</span></label>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" id="floatingInputNIP"
                                placeholder="NIP" autocomplete="off" value="{{ old('nip') }}" inputmode="numeric" maxlength="18" required>
                            <label for="floatingInputNIP">NIP <span class="text-danger">*</span></label>
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror" id="floatingInputDOB"
                                placeholder="Birth Date" autocomplete="off" value="{{ old('dob') }}" required>
                            <label for="floatingInputDOB">Birth Date <span class="text-danger">*</span></label>
                            @error('dob')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select name="gender" id="floatingInputGender" class="form-select @error('gender') is-invalid @enderror" required>
                                <option value="" {{ old('gender') ? '' : 'selected' }} disabled>
                                    Select Gender
                                </option>
                                @foreach (GenderEnum::cases() as $gender)
                                    <option value="{{ $gender->value }}"
                                        {{ old('gender') == $gender->value ? 'selected' : '' }}>
                                        {{ ucfirst(strtolower($gender->value)) }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="floatingInputGender">Gender <span class="text-danger">*</span></label>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 justify-content-center px-4 rounded-pill">
                                <i class="ti ti-device-floppy me-1"></i> Save Teacher
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
document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const removeBtn = document.getElementById('removeImageBtn');
    const placeholder = "{{ asset('static/img/no-image-placeholder.svg') }}";
    imagePreview.addEventListener('click', function () {
        imageInput.click();
    });
    imageInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            imagePreview.src = e.target.result;
            removeBtn.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    });
    removeBtn.addEventListener('click', function () {
        imageInput.value = '';
        imagePreview.src = placeholder;
        removeBtn.classList.add('d-none');
    });
});
</script>
@endpush
