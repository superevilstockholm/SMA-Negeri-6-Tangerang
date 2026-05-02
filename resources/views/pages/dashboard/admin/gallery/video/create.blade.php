@extends('layouts.dashboard')
@section('title', 'Create Video')
@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Create Video</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Create a new video.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.gallery.videos.index') }}"
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
                    <form action="{{ route('dashboard.admin.gallery.videos.store') }}" autocomplete="off"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="file" name="video_file" id="videoInput" class="d-none @error('video_file') is-invalid @enderror" accept="video/*">
                            <div id="videoPreviewWrapper" class="border rounded overflow-hidden position-relative w-100" style="max-width:500px; height:250px; cursor:pointer;">
                                <img src="{{ asset('static/img/no-image-palceholder.svg') }}" id="videoPlaceholder" class="w-100 h-100" style="object-fit:cover; object-position:center;">
                                <video id="videoPreview" class="w-100 h-100 d-none" style="object-fit:cover; object-position:center;" controls playsinline></video>
                            </div>
                            <div class="mt-2 text-muted small">
                                Click preview area to choose video
                            </div>
                            <button type="button" id="removeVideoBtn" class="btn btn-sm btn-danger mt-2 d-none">
                                <i class="ti ti-trash me-1"></i> Remove Video
                            </button>
                            @error('video_file')
                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select name="group_id" id="floatingInputGroup"
                                class="form-select @error('group_id') is-invalid @enderror">
                                <option value="" {{ old('group_id') ? '' : 'selected' }}>Without Group</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                        {{ $group->title }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="floatingInputGroup">Select Group</label>
                            @error('group_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 justify-content-center px-4 rounded-pill">
                                <i class="ti ti-device-floppy me-1"></i> Save Video
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
    const input = document.getElementById('videoInput');
    const wrapper = document.getElementById('videoPreviewWrapper');
    const placeholder = document.getElementById('videoPlaceholder');
    const preview = document.getElementById('videoPreview');
    const removeBtn = document.getElementById('removeVideoBtn');
    wrapper.addEventListener('click', function (e) {
        if (e.target.tagName !== 'VIDEO') {
            input.click();
        }
    });
    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const url = URL.createObjectURL(file);
        preview.src = url;
        preview.load();
        preview.classList.remove('d-none');
        placeholder.classList.add('d-none');
        removeBtn.classList.remove('d-none');
    });
    removeBtn.addEventListener('click', function () {
        input.value = '';
        preview.pause();
        preview.removeAttribute('src');
        preview.load();
        preview.classList.add('d-none');
        placeholder.classList.remove('d-none');
        removeBtn.classList.add('d-none');
    });
});
</script>
@endpush
