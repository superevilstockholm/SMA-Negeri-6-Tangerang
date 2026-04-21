<footer data-bs-theme="dark">
    <div class="bg-primary-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 mb-4">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <a class="text-decoration-none" href="{{ route('index') }}">
                                <img class="d-block" src="{{ asset('static/img/logo-sman6tng.png') }}" alt="Logo {{ config('app.name') }}" width="60">
                            </a>
                        </div>
                        <div class="col-12 reveal">
                            <b>SMAN 6 Tangerang</b> is an educational institution that is committed to producing a superior, character-based, and globally competitive generation.
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-lg-4 mb-3 mb-lg-0">
                            <a class="text-uppercase mb-3 text-white h5 text-decoration-none d-block" href="{{ route('about') }}">About</a>
                            <div class="d-flex flex-column gap-1 reveal">
                                <div class="nav-item">
                                    <a class="nav-link" href="{{ route('about') }}#our-purpose">Our Purpose</a>
                                </div>
                                <div class="nav-item">
                                    <a class="nav-link" href="{{ route('about') }}#vision-and-mission">Vision & Mission</a>
                                </div>
                                <div class="nav-item">
                                    <a class="nav-link" href="{{ route('about') }}#leadership">Leadership</a>
                                </div>
                                <div class="nav-item">
                                    <a class="nav-link" href="{{ route('about') }}#community">Community</a>
                                </div>
                                <div class="nav-item">
                                    <a class="nav-link" href="{{ route('about') }}#faq">FAQ</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4 mb-3 mb-lg-0">
                            <a class="text-uppercase mb-3 text-white h5 text-decoration-none d-block" href="javascript:void(0)">Student Life</a>
                            <div class="d-flex flex-column gap-1 reveal">
                                <div class="nav-item">
                                    <a class="nav-link" href="{{ route('extracurricular') }}">Extracurricular</a>
                                </div>
                                <div class="nav-item">
                                    <a class="nav-link" href="#">Recognition & Awards</a>
                                </div>
                                <div class="nav-item">
                                    <a class="nav-link" href="#">Stories of Impact</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4 mb-3 mb-lg-0">
                            <a class="text-uppercase mb-3 text-white h5 text-decoration-none d-block" href="javascript:void(0)">Others</a>
                            <div class="d-flex flex-column gap-1 reveal">
                                <div class="nav-item">
                                    <a class="nav-link" href="#">Blog</a>
                                </div>
                                <div class="nav-item">
                                    <a class="nav-link" href="#">News</a>
                                </div>
                                <div class="nav-item">
                                    <a class="nav-link" href="#">Events</a>
                                </div>
                                <div class="nav-item">
                                    <a class="nav-link" href="{{ route('contact-us') }}">Contact Us</a>
                                </div>
                                <div class="nav-item d-flex align-items-center gap-3 social-links">
                                    <a class="nav-link" href="https://www.instagram.com/sman6tangerang/" target="_blank">
                                        <i class="bi bi-instagram"></i>
                                    </a>
                                    <a class="nav-link" href="https://www.youtube.com/channel/UC_-pnhlijU9dajU5BSCAZng/" target="_blank">
                                        <i class="bi bi-youtube"></i>
                                    </a>
                                    <a class="nav-link" href="https://x.com/sman6tng/" target="_blank">
                                        <i class="bi bi-twitter-x"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <span class="d-block text-center fs-09">
                        Copyright &copy; {{ date('Y') }} <b>{{ config('app.name') }}</b>. All rights reserved.
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>
@push('css')
    <style>
        footer .nav-item .nav-link {
            transition: all 0.2s ease-in-out;
        }
        footer .nav-item:not(.social-links) .nav-link:hover {
            transform: translateX(10px);
        }
        footer .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        footer .reveal.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
@endpush
@push('js')
    <script>
        const reveals = document.querySelectorAll('footer .reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const index = [...reveals].indexOf(entry.target);

                    setTimeout(() => {
                        entry.target.classList.add('show');
                    }, index * 80);

                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15
        });
        reveals.forEach(el => observer.observe(el));
    </script>
@endpush
