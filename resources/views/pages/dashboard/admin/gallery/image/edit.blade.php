@extends('layouts.dashboard')
@section('title', 'Edit Image')
@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Edit Image</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Update this image.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.gallery.images.index') }}"
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
                    <form action="{{ route('dashboard.admin.gallery.images.update', $image->id) }}" autocomplete="off"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <input type="file" name="image_file" id="imageInput" class="d-none @error('image_file') is-invalid @enderror" accept="image/*">
                            <img src="{{ old('image_file') ? asset('static/img/no-image-palceholder.svg') : asset($image->file_url) }}" id="imagePreview" alt="Preview Image" class="w-100 h-100 rounded object-fit-cover border" style="max-width: 500px; max-height: 250px; object-position: center; cursor: pointer;">
                            <div class="mt-2 text-muted small">
                                Click on the image to choose file
                            </div>
                            <button type="button" id="removeImageBtn" class="btn btn-sm btn-danger mt-2 d-none">
                                <i class="ti ti-trash me-1"></i> Remove Selected Image
                            </button>
                            @error('image_file')
                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select name="group_id" id="floatingInputOrder" class="form-select @error('group_id') is-invalid @enderror">
                                <option value="" {{ old('group_id', $image->group_id) === null ? 'selected' : '' }}>
                                    Without Group
                                </option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}" {{ old('group_id', $image->group_id) == $group->id ? 'selected' : '' }}>
                                        {{ $group->title }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="floatingInputOrder">Select Group</label>
                            @error('group_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 justify-content-center px-4 rounded-pill">
                                <i class="ti ti-device-floppy me-1"></i> Update Image
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

    const originalImage = "{{ asset($image->file_url) }}";

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
        imagePreview.src = originalImage;
        removeBtn.classList.add('d-none');
    });
});
</script>
@endpush
