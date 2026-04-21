@extends('layouts.dashboard')
@section('title', 'Admin')
@section('content')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'This page is not yet available.',
                showConfirmButton: true,
            });
        });
    </script>
@endsection
