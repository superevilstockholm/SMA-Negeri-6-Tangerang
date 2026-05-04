@extends('layouts.dashboard')
@section('title', 'Teacher Management')
@section('content')
    @php
        use App\Enums\GenderEnum;
        use Illuminate\Contracts\Pagination\LengthAwarePaginator;
    @endphp
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Teacher Records</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Manage teacher records.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.master-data.teachers.create') }}"
                            class="btn btn-sm btn-primary px-4 rounded-pill m-0">
                            <i class="ti ti-plus me-1"></i> Create Teacher
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
                    <form method="GET" action="{{ route('dashboard.admin.master-data.teachers.index') }}" id="filterForm">
                        <div
                            class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center mb-3 gap-2 gap-md-0">
                            <div class="d-flex align-items-center">
                                @php
                                    $limits = [5, 10, 25, 50, 100];
                                    $currentLimit = request('limit', 10);
                                @endphp
                                <label for="limitSelect" class="form-label mb-0 me-2">Show</label>
                                <select class="form-select form-select-sm" id="limitSelect" name="limit"
                                    onchange="document.getElementById('filterForm').submit()">
                                    @foreach ($limits as $limit)
                                        <option value="{{ $limit }}"
                                            {{ (string) $currentLimit === (string) $limit ? 'selected' : '' }}>
                                            {{ $limit }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="ms-2">entries</span>
                            </div>
                            <div class="text-muted small">
                                @if ($teachers instanceof LengthAwarePaginator)
                                    Showing {{ $teachers->firstItem() }} to {{ $teachers->lastItem() }} of
                                    {{ $teachers->total() }} entries
                                @else
                                    Showing {{ $teachers->count() }} entries
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3 g-2">
                            {{-- Name --}}
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" name="name" class="form-control form-control-sm"
                                        id="filterName" placeholder="Name" value="{{ request('name') }}">
                                    <label for="filterName">Name</label>
                                </div>
                            </div>
                            {{-- NIP --}}
                            <div class="col-12 col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="nip" class="form-control form-control-sm"
                                        id="filterNIP" placeholder="NIP" value="{{ request('nip') }}">
                                    <label for="filterNIP">NIP</label>
                                </div>
                            </div>
                            {{-- Gender --}}
                            <div class="col-12 col-md-6">
                                <div class="form-floating">
                                    <select name="gender" id="filterGender" class="form-select @error('gender') is-invalid @enderror">
                                        <option value="" {{ old('gender', request('gender')) === null || old('gender', request('gender')) === '' ? 'selected' : '' }}>
                                            All Gender
                                        </option>
                                        @foreach (GenderEnum::cases() as $gender)
                                            <option value="{{ $gender->value }}"
                                                {{ old('gender', request('gender')) == $gender->value ? 'selected' : '' }}>
                                                {{ ucfirst(strtolower($gender->value)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="filterGender">Gender</label>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- Start Birth Date --}}
                            <div class="col-12 col-md-6">
                                <div class="form-floating">
                                    <input type="date" name="start_dob" class="form-control form-control-sm"
                                        id="filterStartBirthDate" value="{{ request('start_dob') }}">
                                    <label for="filterStartBirthDate">Start Birth Date</label>
                                </div>
                            </div>
                            {{-- End Birth Date --}}
                            <div class="col-12 col-md-6">
                                <div class="form-floating">
                                    <input type="date" name="end_dob" class="form-control form-control-sm"
                                        id="filterEndBirthDate" value="{{ request('end_dob') }}">
                                    <label for="filterEndBirthDate">End Birth Date</label>
                                </div>
                            </div>
                            {{-- Start Date --}}
                            <div class="col-12 col-md-6">
                                <div class="form-floating">
                                    <input type="date" name="start_date" class="form-control form-control-sm"
                                        id="filterStartDate" value="{{ request('start_date') }}">
                                    <label for="filterStartDate">Start Date</label>
                                </div>
                            </div>
                            {{-- End Date --}}
                            <div class="col-12 col-md-6">
                                <div class="form-floating">
                                    <input type="date" name="end_date" class="form-control form-control-sm"
                                        id="filterEndDate" value="{{ request('end_date') }}">
                                    <label for="filterEndDate">End Date</label>
                                </div>
                            </div>
                            {{-- Search Buttons --}}
                            <div class="col-12 col-md-6">
                                <button type="submit"
                                    class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
                                    <i class="ti ti-search"></i> Search
                                </button>
                            </div>
                            {{-- Reset Buttons --}}
                            <div class="col-12 col-md-6">
                                <a href="{{ route('dashboard.admin.master-data.teachers.index') }}"
                                    class="btn btn-secondary w-100 d-flex align-items-center justify-content-center gap-2">
                                    <i class="ti ti-rotate-clockwise-2"></i> Reset Filters
                                </a>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive @if (!($teachers instanceof LengthAwarePaginator && $teachers->hasPages())) mb-0 @else mb-3 @endif">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>NIP</th>
                                    <th>Has User</th>
                                    <th>Created At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($teachers as $index => $teacher)
                                    <tr>
                                        <td class="text-center">
                                            @if ($teachers instanceof LengthAwarePaginator)
                                                {{ $teachers->firstItem() + $loop->index }}
                                            @else
                                                {{ $loop->iteration }}
                                            @endif
                                        </td>
                                        <td>
                                            <img class="rounded object-fit-cover" style="width: 100px; height: 100px;" src="{{ $teacher->photo_url }}" alt="{{ $teacher->name ? ucwords(strtolower($teacher->name)) . ' Photo' : 'Teacher Photo ' . $teacher->id }}">
                                        </td>
                                        <td>{{ $teacher->name ? ucwords(strtolower($teacher->name)) : '-' }}</td>
                                        <td>{{ $teacher->nip ?? '-' }}</td>
                                        <td>{{ $teacher->user ? 'Yes' : 'No' }}</td>
                                        <td>{{ $teacher->created_at?->format('d M Y H:i') }}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button type="button" class="btn border-0 p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                                        href="{{ route('dashboard.admin.master-data.teachers.show', $teacher->id) }}">
                                                        <i class="ti ti-eye me-1"></i> View Details
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                                        href="{{ route('dashboard.admin.master-data.teachers.edit', $teacher->id) }}">
                                                        <i class="ti ti-pencil me-1"></i> Edit
                                                    </a>
                                                    <form id="form-delete-{{ $teacher->id }}"
                                                        action="{{ route('dashboard.admin.master-data.teachers.destroy', $teacher->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="dropdown-item d-flex align-items-center gap-2 text-danger btn-delete"
                                                            data-id="{{ $teacher->id }}" data-name="{{ $teacher->name ? ucwords(strtolower($teacher->name)) : '-' }}">
                                                            <i class="ti ti-trash me-1 text-danger"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="alert alert-warning my-2" role="alert">
                                                No teacher records found for the selected filters.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($teachers instanceof LengthAwarePaginator && $teachers->hasPages())
                        <div class="overflow-x-auto mt-0 py-1">
                            <div class="d-flex justify-content-center d-md-block w-100 px-3">
                                {{ $teachers->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-delete').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const teacherId = this.getAttribute('data-id');
                    const teacherName = this.getAttribute('data-name');
                    Swal.fire({
                        title: "Delete Teacher",
                        text: "Are you sure you want to delete the following teacher: \"" + teacherName +
                            "\"? This action cannot be undone.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, Delete",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('form-delete-' + teacherId).submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
