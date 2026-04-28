@extends('layouts.dashboard')
@section('title', 'School History Management')
@section('content')
    @php
        use Illuminate\Support\Str;
        use Illuminate\Contracts\Pagination\LengthAwarePaginator;
    @endphp
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">School History Records</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Manage school history records.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.master-data.school-histories.create') }}"
                            class="btn btn-sm btn-primary px-4 rounded-pill m-0">
                            <i class="ti ti-plus me-1"></i> Create School History
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
                    <form method="GET" action="{{ route('dashboard.admin.master-data.school-histories.index') }}" id="filterForm">
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
                                @if ($schoolHistories instanceof LengthAwarePaginator)
                                    Showing {{ $schoolHistories->firstItem() }} to {{ $schoolHistories->lastItem() }} of
                                    {{ $schoolHistories->total() }} entries
                                @else
                                    Showing {{ $schoolHistories->count() }} entries
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3 g-2">
                            {{-- Title --}}
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" name="title" class="form-control form-control-sm"
                                        id="filterTitle" placeholder="Title" value="{{ request('title') }}">
                                    <label for="filterTitle">Title</label>
                                </div>
                            </div>
                            {{-- Description --}}
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" name="description" class="form-control form-control-sm"
                                        id="filterDescription" placeholder="Description" value="{{ request('description') }}">
                                    <label for="filterDescription">Description</label>
                                </div>
                            </div>
                            {{-- Start Year --}}
                            <div class="col-12 col-lg-6">
                                <div class="form-floating">
                                    <input type="number" name="start_year" class="form-control form-control-sm"
                                        id="filterStartYear" placeholder="Start Year" value="{{ request('start_year') }}">
                                    <label for="filterStartYear">Start Year</label>
                                </div>
                            </div>
                            {{-- End Year --}}
                            <div class="col-12 col-lg-6">
                                <div class="form-floating">
                                    <input type="number" name="end_year" class="form-control form-control-sm"
                                        id="filterEndYear" placeholder="End Year" value="{{ request('end_year') }}">
                                    <label for="filterEndYear">End Year</label>
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
                                <a href="{{ route('dashboard.admin.master-data.school-histories.index') }}"
                                    class="btn btn-secondary w-100 d-flex align-items-center justify-content-center gap-2">
                                    <i class="ti ti-rotate-clockwise-2"></i> Reset Filters
                                </a>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive @if (!($schoolHistories instanceof LengthAwarePaginator && $schoolHistories->hasPages())) mb-0 @else mb-3 @endif">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Period</th>
                                    <th>Created At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($schoolHistories as $index => $schoolHistory)
                                    <tr>
                                        <td class="text-center">
                                            @if ($schoolHistories instanceof LengthAwarePaginator)
                                                {{ $schoolHistories->firstItem() + $loop->index }}
                                            @else
                                                {{ $loop->iteration }}
                                            @endif
                                        </td>
                                        <td>{{ $schoolHistory->title ?? '-' }}</td>
                                        <td>{{ $schoolHistory->description ? Str::limit($schoolHistory->description, 60) : '-' }}</td>
                                        <td>{{ $schoolHistory->start_year . ($schoolHistory->end_year ? ' - ' . $schoolHistory->end_year : '')}}</td>
                                        <td>{{ $schoolHistory->created_at?->format('d M Y H:i') }}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button type="button" class="btn border-0 p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                                        href="{{ route('dashboard.admin.master-data.school-histories.show', $schoolHistory->id) }}">
                                                        <i class="ti ti-eye me-1"></i> View Details
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                                        href="{{ route('dashboard.admin.master-data.school-histories.edit', $schoolHistory->id) }}">
                                                        <i class="ti ti-pencil me-1"></i> Edit
                                                    </a>
                                                    <form id="form-delete-{{ $schoolHistory->id }}"
                                                        action="{{ route('dashboard.admin.master-data.school-histories.destroy', $schoolHistory->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="dropdown-item d-flex align-items-center gap-2 text-danger btn-delete"
                                                            data-id="{{ $schoolHistory->id }}"
                                                            data-title="{{ $schoolHistory->title ?? '-' }}">
                                                            <i class="ti ti-trash me-1 text-danger"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <div class="alert alert-warning my-2" role="alert">
                                                No school history records found for the selected filters.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($schoolHistories instanceof LengthAwarePaginator && $schoolHistories->hasPages())
                        <div class="overflow-x-auto mt-0 py-1">
                            <div class="d-flex justify-content-center d-md-block w-100 px-3">
                                {{ $schoolHistories->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
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
                    const schoolHistoryId = this.getAttribute('data-id');
                    const schoolHistoryTitle = this.getAttribute('data-title');
                    Swal.fire({
                        title: "Delete School History",
                        text: "Are you sure you want to delete the following school history: \"" + schoolHistoryTitle +
                            "\"? This action cannot be undone.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, Delete",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('form-delete-' + schoolHistoryId).submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
