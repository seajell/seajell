@extends('install.layout')
@section('page') Laman Utama @endsection
@section('content')
<div class="container d-flex flex-column h-auto align-items-center bg-dark my-5 text-light rounded-3 shadow-lg">
    <h1 class="mt-5">Skrip Instalasi Sistem - {{ env('APP_NAME') }}</h1>
    <h2>Laman Utama</h2>
    <hr class="border-light w-100 border-4">
    <p class="fs-4">
        Pastikan anda telah memastikan kesemua <span class="fst-italic">requirements</span> dipenuhi sebelum pemasangan.
    </p>
    <p class="fs-4">
        Skrip ini akan menambah pengguna <span class="fst-italic fw-bold">admin</span> baharu dan membuat <span class="fst-italic">database migration</span class="fst-italic">.
    </p>
    <a href="{{ route('install.config') }}" class="btn w-50 my-5 hvr-shrink btn-outline-light fs-4">Teruskan <i class="bi bi-box-arrow-right"></i></a>
</div>
@endsection