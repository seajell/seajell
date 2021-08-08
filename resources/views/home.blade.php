@extends('layout.main')
@section('content')
    <div class="container d-flex flex-column align-items-center">
        <div class="row my-3">
            <p class="fs-2">Navigasi</p>
        </div>
        <div class="row mb-3">
            <a href="{{ route('certificate.list') }}" class="btn btn-dark fs-5"><i class="bi bi-patch-check"></i> Senarai Sijil</a>
        </div>
    </div>
@endsection