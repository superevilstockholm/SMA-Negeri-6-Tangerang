@extends('layouts.dashboard')
@section('title', 'Contact Details')
@section('content')
    <x-alerts :errors="$errors" />
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Contact Details</h3>
                        <p class="p-0 m-0 fw-medium text-muted">View detailed information about this contact.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.master-data.contacts.index') }}"
                            class="btn btn-sm btn-primary d-flex align-items-center gap-2 justify-content-center px-4 rounded-pill m-0">
                            <i class="ti ti-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title fw-semibold mb-3">Contact Details</h4>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Name</div>
                        <div class="col-md-8 fw-medium">{{ $contact->name ? ucwords(strtolower($contact->name)) : '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Email</div>
                        <div class="col-md-8 fw-medium">{{ $contact->email ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Phone</div>
                        <div class="col-md-8 fw-medium">{{ $contact->phone ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-muted">Message</div>
                        <div class="col-md-12 fw-medium">{!! $contact->message ?? '-' !!}</div>
                    </div>
                    <h4 class="card-title fw-semibold mt-4 mb-3">System Information</h4>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Contact ID</div>
                        <div class="col-md-8 fw-medium">{{ $contact->id ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Created At</div>
                        <div class="col-md-8 fw-medium">{{ $contact->created_at?->format('d M Y H:i:s') ?? '-' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-muted">Updated At</div>
                        <div class="col-md-8 fw-medium">{{ $contact->updated_at?->format('d M Y H:i:s') ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card my-0">
                <div class="card-body">
                    <h4 class="card-title fw-semibold mb-3">Quick Actions</h4>
                    <form id="form-delete-{{ $contact->id }}"
                        action="{{ route('dashboard.admin.master-data.contacts.destroy', $contact->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger d-flex align-items-center gap-2 justify-content-center w-100 btn-delete" data-id="{{ $contact->id }}"
                            data-name="{{ $contact->name ? ucwords(strtolower($contact->name)) : '-' }}">
                            <i class="ti ti-trash me-1"></i> Delete Contact
                        </button>
                    </form>
                    <hr class="my-4">
                    <h4 class="card-title fw-semibold mb-3">Notes</h4>
                    <p class="text-muted small">
                        This page displays detailed information about the selected contact. To delete, click the "Delete Contact" button.
                    </p>
                </div>
            </div>
        </div>
    </div>
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
@endsection
