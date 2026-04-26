@extends('layouts.base')
@section('title', 'Contact Us')
@section('meta-description', 'Hubungi SMAN 6 Tangerang untuk informasi sekolah, pendaftaran, layanan administrasi, kerja sama, dan pertanyaan umum. Temukan alamat, nomor telepon, email, serta formulir kontak resmi kami.')
@section('meta-keywords', 'contact us SMAN 6 Tangerang, kontak SMAN 6 Tangerang, alamat SMAN 6 Tangerang, nomor telepon SMAN 6 Tangerang, email SMAN 6 Tangerang, sekolah negeri Tangerang, SMA Negeri 6 Kota Tangerang, hubungi sekolah Tangerang, pendaftaran SMAN 6 Tangerang')
@section('content')
    <section class="position-relative">
        <div class="container-fluid" data-bs-theme="dark">
            <div class="row">
                <div class="col px-0 position-relative">
                    <img class="w-100 h-100 object-fit-cover" style="max-height: 380px;"
                        src="{{ asset('static/img/contact-us-header-image.jpg') }}" alt="Contact Us Header Image">
                    <div
                        class="position-absolute z-1 w-100 h-100 d-flex align-items-center justify-content-center top-0 start-0 bg-dark bg-opacity-50 pb-30px pb-lg-60px">
                        <h1 class="p-0 m-0 text-white fw-bold display-4">Contact Us</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-absolute z-2 w-100 top-100 start-0" style="transform: translateY(-100%);">
            <div class="d-flex align-items-start">
                <div class="bg-body flex-grow-1" style="height: 30px;"></div>
                <div class="container d-flex p-0" style="flex: 0 0 auto; width: 100%;">
                    <div class="bg-body" style="flex: 2; height: 30px;"></div>
                    <div class="bg-body" style="width: 30px; height: 30px; border-top-right-radius: 100%;"></div>
                    <div class="bg-body" style="width: 30px; height: 30px; border-top-left-radius: 100%;"></div>
                    <div class="bg-body" style="flex: 1; height: 30px;"></div>
                </div>
                <div class="bg-body flex-grow-1" style="height: 30px;"></div>
            </div>
        </div>
    </section>
    <section class="position-relative pb-60px pb-lg-90px pt-30px pt-lg-60px" id="contact-form">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                    <h1 class="display-6 fw-bold mb-0 d-flex align-items-center text-primary">
                        <span class="bg-primary d-block me-3 me-lg-4"
                            style="width: 23px; height: 23px; transform: rotate(45deg);"></span>
                        Let Us Assist You
                    </h1>
                </div>
                <div class="col-12 col-lg-6">
                    <form autocomplete="off" class="p-0 m-0" action="{{ route('contact-us-attempt') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3 reveal">
                            <label for="name" class="form-label fw-medium mb-0">Full Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm border-0 border-bottom rounded-0 bg-transparent"
                                id="name" name="name" value="{{ old('name') }}" autocomplete="off" required>
                        </div>
                        <div class="form-group mb-3 reveal">
                            <label for="email" class="form-label fw-medium mb-0">Email Address <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-sm border-0 border-bottom rounded-0 bg-transparent"
                                id="email" name="email" value="{{ old('email') }}" autocomplete="off" required>
                        </div>
                        <div class="form-group mb-3 reveal">
                            <label for="phone" class="form-label fw-medium mb-0">Phone</label>
                            <input type="text" class="form-control form-control-sm border-0 border-bottom rounded-0 bg-transparent"
                                id="phone" name="phone" value="{{ old('phone') }}" placeholder="+62" autocomplete="off">
                        </div>
                        <div class="form-group mb-3 reveal">
                            <label for="message" class="form-label fw-medium mb-0">Message <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm border-0 border-bottom rounded-0 bg-transparent" id="message" name="message"
                                autocomplete="off" required>{{ old('message') }}</textarea>
                        </div>
                        <button class="btn btn-sm btn-primary-dark w-100 reveal" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="position-absolute z-2 w-100 top-100 start-0" style="transform: translateY(-100%);">
            <div class="d-flex align-items-start">
                <div class="bg-primary-dark flex-grow-1" style="height: 30px;"></div>
                <div class="container d-flex p-0" style="flex: 0 0 auto; width: 100%;">
                    <div class="bg-primary-dark" style="flex: 2; height: 30px;"></div>
                    <div class="bg-primary-dark" style="width: 30px; height: 30px; border-top-right-radius: 100%;"></div>
                    <div class="bg-primary-dark" style="width: 30px; height: 30px; border-top-left-radius: 100%;"></div>
                    <div class="bg-primary-dark" style="flex: 1; height: 30px;"></div>
                </div>
                <div class="bg-primary-dark flex-grow-1" style="height: 30px;"></div>
            </div>
        </div>
    </section>
    <section class="position-relative bg-primary-dark pb-60px pb-lg-90px pt-30px pt-lg-60px" id="contact-map">
        <div class="container">
            <div class="row">
                <div class="col" style="height: 450px;">
                    <iframe class="w-100 h-100 border-0 rounded-3 reveal" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d589.0263904843035!2d106.64510898206639!3d-6.1611566416457775!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f8b8b5a2c581%3A0x953db60512db4685!2sSMAN%206%20TANGERANG!5e0!3m2!1sid!2sid!4v1777166345604!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
        <div class="position-absolute z-2 w-100 top-100 start-0" style="transform: translateY(-100%);">
            <div class="d-flex align-items-start">
                <div class="bg-body flex-grow-1" style="height: 30px;"></div>
                <div class="container d-flex p-0" style="flex: 0 0 auto; width: 100%;">
                    <div class="bg-body" style="flex: 2; height: 30px;"></div>
                    <div class="bg-body" style="width: 30px; height: 30px; border-top-right-radius: 100%;"></div>
                    <div class="bg-body" style="width: 30px; height: 30px; border-top-left-radius: 100%;"></div>
                    <div class="bg-body" style="flex: 1; height: 30px;"></div>
                </div>
                <div class="bg-body flex-grow-1" style="height: 30px;"></div>
            </div>
        </div>
    </section>
    <section class="pb-30px pb-lg-60px pt-30px pt-lg-60px" id="contact-option">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-4 d-flex align-items-start mb-4 mb-lg-0 reveal">
                    <i class="bi bi-envelope fs-1 py-0 my-0"></i>
                    <div class="d-flex flex-column ms-3">
                        <h5 class="mb-0 fw-bold ff-inter text-uppercase">Email</h5>
                        <p class="mb-0 fw-medium ff-inter">sman6tangerangkota@gmail.com</p>
                    </div>
                </div>
                <div class="col-12 col-lg-3 d-flex align-items-start mb-4 mb-lg-0 reveal">
                    <i class="bi bi-phone fs-1 py-0 my-0"></i>
                    <div class="d-flex flex-column ms-3">
                        <h5 class="mb-0 fw-bold ff-inter text-uppercase">Phone</h5>
                        <p class="mb-0 fw-medium ff-inter">(021) 5587229</p>
                    </div>
                </div>
                <div class="col-12 col-lg-5 d-flex align-items-start mb-4 mb-lg-0 reveal">
                    <i class="bi bi-geo-alt fs-1 py-0 my-0"></i>
                    <div class="d-flex flex-column ms-3">
                        <h5 class="mb-0 fw-bold ff-inter text-uppercase">Address</h5>
                        <p class="mb-0 fw-medium ff-inter">Jln. Nyimas Melati No. 2, Kel. Karanganyar, Kec. Neglasari, Kota Tangerang, Prov Banten, 15121, Indonesia</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('css')
    <style>
        input,
        input:hover,
        input:focus,
        input:active,
        textarea,
        textarea:hover,
        textarea:focus,
        textarea:active {
            -webkit-box-shadow: 0 0 0 0 transparent inset !important;
            box-shadow: 0 0 0 0 transparent inset !important;
            color: var(--bs-body-color) !important;
        }
        html[data-bs-theme="dark"] .border-0 {
            border: none !important;
        }
        html[data-bs-theme="dark"] .bg-transparent {
            background-color: transparent !important;
        }
        html[data-bs-theme="dark"] .border-bottom {
            border-bottom: 1px solid rgba(var(--bs-body-color-rgb), 0.1) !important;
        }
    </style>
@endpush
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reveals = document.querySelectorAll('#contact-form .reveal');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const index = Array.from(reveals).indexOf(entry.target);
                        setTimeout(() => {
                            entry.target.classList.add('show');
                        }, index * 100);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15
            });
            reveals.forEach(el => observer.observe(el));
        });

        document.addEventListener('DOMContentLoaded', function() {
            const reveals = document.querySelectorAll('#contact-map .reveal');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const index = Array.from(reveals).indexOf(entry.target);
                        setTimeout(() => {
                            entry.target.classList.add('show');
                        }, index * 100);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15
            });
            reveals.forEach(el => observer.observe(el));
        });

        document.addEventListener('DOMContentLoaded', function() {
            const reveals = document.querySelectorAll('#contact-option .reveal');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const index = Array.from(reveals).indexOf(entry.target);
                        setTimeout(() => {
                            entry.target.classList.add('show');
                        }, index * 150);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15
            });
            reveals.forEach(el => observer.observe(el));
        });
    </script>
@endpush
