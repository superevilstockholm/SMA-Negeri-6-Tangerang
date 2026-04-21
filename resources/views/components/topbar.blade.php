@php
    use Illuminate\Support\Str;
@endphp
<header class="pc-header">
    <div class="header-wrapper">
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                {{-- Sidebar Collapse --}}
                <li class="pc-h-item header-mobile-collapse">
                    <a href="javascript:void(0);" class="pc-head-link head-link-secondary ms-0" id="sidebar-hide">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="javascript:void(0);" class="pc-head-link head-link-secondary ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="ms-auto">
            <ul class="list-unstyled">
                {{-- Notification --}}
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link head-link-secondary dropdown-toggle arrow-none me-0"
                        data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                        aria-expanded="false">
                        <i class="ti ti-bell"></i>
                    </a>
                    <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header">
                            <h5 class="d-flex align-items-center justify-content-between text-body">
                                Notifikasi Terbaru
                                <span class="badge bg-primary rounded-pill d-flex align-items-center gap-1" style="cursor: pointer !important;">
                                    <i class="ti ti-bell-check"></i>
                                    Tandai Semua
                                </span>
                            </h5>
                        </div>
                        <div class="dropdown-header px-0 text-wrap header-notification-scroll position-relative"
                            style="max-height: calc(100vh - 215px)">
                            <div class="list-group list-group-flush w-100">
                                {{-- Notifications --}}
                                <div class="list-group-item text-center">
                                    Tidak ada notifikasi
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="text-center py-2">
                            <a href="#" class="link-primary">Lihat semua notifikasi</a>
                        </div>
                    </div>
                </li>
                {{-- User Profile --}}
                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link head-link-primary dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ auth()->user()?->profile?->avatar ?? asset('static/img/default-profile-picture.svg') }}" alt="user-image" class="user-avtar object-fit-cover" style="width: 34px; height: 34px;" />
                        <span>
                            <i class="ti ti-settings"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header">
                            <h4 class="d-flex align-items-center gap-1">
                                <span class="text-body">
                                    <?php
                                        date_default_timezone_set('Asia/Jakarta');
                                        $hour = date('H');
                                        $greeting = '';
                                        if ($hour >= 5 && $hour < 12) {
                                            $greeting = 'Selamat Pagi';
                                        } elseif ($hour >= 12 && $hour < 17) {
                                            $greeting = 'Selamat Siang';
                                        } elseif ($hour >= 17 && $hour < 21) {
                                            $greeting = 'Selamat Sore';
                                        } else {
                                            $greeting = 'Selamat Malam';
                                        }
                                        echo $greeting . ',';
                                    ?>
                                </span>
                                <span class="small text-muted text-truncate d-inline-block fs-09" style="max-width: 120px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{ auth()->user()?->profile?->name ?? 'Unknown' }}</span>
                            </h4>
                            <hr />
                            <div class="profile-notification-scroll position-relative"
                                style="max-height: calc(100vh - 280px)">
                                <a href="javascript:void(0);"
                                    class="dropdown-item text-body">
                                    <i class="ti ti-user"></i>
                                    <span>Account Profile</span>
                                </a>
                                <a href="javascript:void(0);" id="theme-button" class="dropdown-item text-body">
                                    <i class="ti" id="theme-icon"></i>
                                    <span>Theme</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout_attempt') }}" method="POST">
                                    @csrf
                                    <button id="logout-button" type="submit" class="dropdown-item text-body">
                                        <i class="ti ti-logout"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const theme = localStorage.getItem('theme') || 'light';
        applyThemeIcon(theme);
        document.getElementById('theme-button').addEventListener('click', function() {
            const current = document.documentElement.getAttribute('data-bs-theme');
            const next = current === 'light' ? 'dark' : 'light';
            applyTheme(next);
            applyThemeIcon(next);
        });
    });
    document.getElementById('logout-button').addEventListener('click', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin ingin logout?',
            text: 'Sesi kamu akan diakhiri.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            confirmButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    });
</script>
<style>
    html[data-bs-theme="dark"] .list-group-item  {
        --bs-list-group-bg: rgb(29, 29, 29) !important;
    }
    html[data-bs-theme="dark"] .list-group-item-action:active,
    html[data-bs-theme="dark"] .list-group-item-action:hover,
    html[data-bs-theme="dark"] .list-group-item-action:focus {
        background: rgb(33, 33, 33) !important;
    }
</style>
