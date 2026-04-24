@extends('layouts.base')
@section('title', 'Contact Us')
@section('content')
    <section class="mb-4 mb-lg-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col px-0 position-relative">
                    <img class="w-100 h-100 object-fit-cover" style="max-height: 350px;"
                        src="{{ asset('static/img/contact-us-header-image.jpg') }}" alt="Contact Us Header Image">
                    <div
                        class="position-absolute z-1 w-100 h-100 d-flex align-items-center justify-content-center top-0 start-0 bg-dark bg-opacity-50">
                        <h1 class="p-0 m-0 text-white fw-semibold display-4">Contact Us</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="mb-4 mb-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                    <h1 class="display-6 fw-medium mb-0 d-flex align-items-center text-primary">
                        <span class="bg-primary d-block me-3 me-lg-4"
                            style="width: 23px; height: 23px; transform: rotate(45deg);"></span>
                        Let Us Assist You
                    </h1>
                </div>
                <div class="col-12 col-lg-6">
                    <form autocomplete="off" class="p-0 m-0" action="{{ route('contact-us-attempt') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name" class="form-label fw-medium mb-0">Full Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm border-0 border-bottom rounded-0 bg-transparent"
                                id="name" name="name" value="{{ old('name') }}" autocomplete="off" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label fw-medium mb-0">Email Address <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-sm border-0 border-bottom rounded-0 bg-transparent"
                                id="email" name="email" value="{{ old('email') }}" autocomplete="off" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label fw-medium mb-0">Phone</label>
                            <input type="text" class="form-control form-control-sm border-0 border-bottom rounded-0 bg-transparent"
                                id="phone" name="phone" value="{{ old('phone') }}" autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label for="message" class="form-label fw-medium mb-0">Message <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm border-0 border-bottom rounded-0 bg-transparent" id="message" name="message"
                                autocomplete="off" required>{{ old('message') }}</textarea>
                        </div>
                        <button class="btn btn-sm btn-primary w-100" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="mb-4 mb-lg-5">
        <div class="container">
            <div class="row">
                <div class="col" style="height: 450px;">
                    <iframe class="w-100 h-100 border-0 rounded-3"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d626.2898128900872!2d106.64528558440489!3d-6.161056796023141!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f8b8b5a2c581%3A0x953db60512db4685!2sSMAN%206%20TANGERANG!5e1!3m2!1sid!2sid!4v1777038122431!5m2!1sid!2sid"
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
        input:active {
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
