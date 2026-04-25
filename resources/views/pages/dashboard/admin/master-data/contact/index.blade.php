@extends('layouts.dashboard')
@section('title', 'Contact Management')
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
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Contact Records</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Manage contact records.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card my-0">
                <div class="card-body">
                    <form method="GET" action="{{ route('dashboard.admin.master-data.contacts.index') }}" id="filterForm">
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
                                @if ($contacts instanceof LengthAwarePaginator)
                                    Showing {{ $contacts->firstItem() }} to {{ $contacts->lastItem() }} of
                                    {{ $contacts->total() }} entries
                                @else
                                    Showing {{ $contacts->count() }} entries
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3 g-2">
                            {{-- Name --}}
                            <div class="col-12 col-lg-4">
                                <div class="form-floating">
                                    <input type="text" name="name" class="form-control form-control-sm"
                                        id="filterName" placeholder="Name" value="{{ request('name') }}">
                                    <label for="filterName">Name</label>
                                </div>
                            </div>
                            {{-- Email --}}
                            <div class="col-12 col-lg-4">
                                <div class="form-floating">
                                    <input type="text" name="email" class="form-control form-control-sm"
                                        id="filterEmail" placeholder="Email" value="{{ request('email') }}">
                                    <label for="filterEmail">Email</label>
                                </div>
                            </div>
                            {{-- Phone --}}
                            <div class="col-12 col-lg-4">
                                <div class="form-floating">
                                    <input type="text" name="phone" class="form-control form-control-sm"
                                        id="filterPhone" placeholder="Phone" value="{{ request('phone') }}">
                                    <label for="filterPhone">Phone</label>
                                </div>
                            </div>
                            {{-- Message --}}
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" name="message" class="form-control form-control-sm"
                                        id="filterMessage" placeholder="Message" value="{{ request('message') }}">
                                    <label for="filterMessage">Message</label>
                                </div>
                            </div>
                            {{-- Start Date --}}
                            <div class="col-12 col-md-6">
                                <div class="form-floating">
                                    <input type="date" name="startDate" class="form-control form-control-sm"
                                        id="filterStartDate" value="{{ request('startDate') }}">
                                    <label for="filterStartDate">Start Date</label>
                                </div>
                            </div>
                            {{-- End Date --}}
                            <div class="col-12 col-md-6">
                                <div class="form-floating">
                                    <input type="date" name="endDate" class="form-control form-control-sm"
                                        id="filterEndDate" value="{{ request('endDate') }}">
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
                                <a href="{{ route('dashboard.admin.master-data.contacts.index') }}"
                                    class="btn btn-secondary w-100 d-flex align-items-center justify-content-center gap-2">
                                    <i class="ti ti-rotate-clockwise-2"></i> Reset Filters
                                </a>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive @if (!($contacts instanceof LengthAwarePaginator && $contacts->hasPages())) mb-0 @else mb-3 @endif">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Created At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($contacts as $index => $contact)
                                    <tr>
                                        <td class="text-center">
                                            @if ($contacts instanceof LengthAwarePaginator)
                                                {{ $contacts->firstItem() + $loop->index }}
                                            @else
                                                {{ $loop->iteration }}
                                            @endif
                                        </td>
                                        <td>{{ $contact->name ? ucwords(strtolower($contact->name)) : '-' }}</td>
                                        <td>{{ $contact->email ?? '-' }}</td>
                                        <td>{{ $contact->phone ?? '-' }}</td>
                                        <td>{{ $contact->message ? Str::limit($contact->message, 60) : '-' }}</td>
                                        <td>{{ $contact->created_at?->format('d M Y H:i') }}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button type="button" class="btn border-0 p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                                        href="{{ route('dashboard.admin.master-data.contacts.show', $contact->id) }}">
                                                        <i class="ti ti-eye me-1"></i> View Details
                                                    </a>
                                                    <form id="form-delete-{{ $contact->id }}"
                                                        action="{{ route('dashboard.admin.master-data.contacts.destroy', $contact->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="dropdown-item d-flex align-items-center gap-2 text-danger btn-delete"
                                                            data-id="{{ $contact->id }}"
                                                            data-name="{{ $contact->name ? ucwords(strtolower($contact->name)) : '-' }}">
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
                                                No contact records found for the selected filters.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($contacts instanceof LengthAwarePaginator && $contacts->hasPages())
                        <div class="overflow-x-auto mt-0 py-1">
                            <div class="d-flex justify-content-center d-md-block w-100 px-3">
                                {{ $contacts->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
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
                    const contactId = this.getAttribute('data-id');
                    const contactName = this.getAttribute('data-name');
                    Swal.fire({
                        title: "Delete Contact",
                        text: "Are you sure you want to delete the following contact: \"" + contactName +
                            "\"? This action cannot be undone.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, Delete",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('form-delete-' + contactId).submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
