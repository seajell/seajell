@extends('install.layout')
@section('page') Berjaya @endsection
@section('content')
<div class="container d-flex flex-column h-auto align-items-center bg-dark my-5 text-light rounded-3 shadow-lg">
    <h1 class="mt-5">Skrip Instalasi Sistem - {{ env('APP_NAME') }}</h1>
    <h2>Tamat</h2>
    <hr class="border-light w-100 border-4">
    <p class="fs-4">
        Pemasangan Berjaya!
    </p>
    <a href="{{ route('login') }}" class="btn w-50 my-5 hvr-shrink btn-outline-light fs-4">Log Masuk <i class="bi bi-box-arrow-right"></i></a>
</div>
@endsection