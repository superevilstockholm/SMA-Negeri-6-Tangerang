@props(['errors'])
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Flash messages
        @foreach (['success', 'error', 'warning', 'info'] as $msg)
            @if (session($msg))
                Swal.fire({
                    icon: '{{ $msg === 'error' ? 'error' : $msg }}',
                    title: '{{ ucfirst($msg) }}',
                    text: '{{ session($msg) }}',
                    timer: 2500,
                    timerProgressBar: true,
                    showConfirmButton: false,
                });
            @endif
        @endforeach
        // Validation errors
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ $errors->first() }}',
                timer: 2500,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        @endif
    });
</script>
