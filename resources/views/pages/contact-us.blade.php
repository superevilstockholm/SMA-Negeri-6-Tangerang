@extends('layouts.base')
@section('title', 'Contact Us')
@section('content')
    <section class="mb-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col px-0 position-relative">
                    <img class="w-100 h-100 object-fit-cover" style="max-height: 350px;"
                        src="{{ asset('static/img/contact-us-header-image.jpg') }}" alt="Contact Us Header Image">
                    <div
                        class="position-absolute z-1 w-100 h-100 d-flex align-items-center justify-content-center top-0 start-0 bg-dark bg-opacity-50">
                        <h1 class="p-0 m-0 text-white fw-semibold">Contact Us</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="mb-4">
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
