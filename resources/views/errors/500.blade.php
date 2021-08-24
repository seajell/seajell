@extends('errors.layout')
@section('title')
    Error 500
@endsection
@section('content')
    <div class="row d-flex justify-content-center align-items-center">
        <img src="{{ asset('storage/errors/500/500-SeaJell.svg') }}" class="img-fluid" alt="Error Image" style="width: 85vw;">
    </div>
    <div class="row d-flex justify-content-center align-items-center mt-3 mb-5">
        <h2 class="text-center text-light mb-5">{{ $exception->getMessage() }}</h2>
        <a href="{{ route('home') }}" class="btn btn-light text-center w-50 mb-5"><i class="bi bi-house"></i> Kembali Ke Laman Utama</a>
    </div>
@endsection