@extends('layout.main')
@section('content')
    <div class="container text-center">
        <div class="row">
            <p class="fs-2">Navigasi</p>
        </div>
        <div class="row mb-3">
            <div class="col">
                <a href="{{ route('certificate.list') }}" class="fs-4 w-25 btn btn-dark"><i class="bi bi-patch-check"></i> Sijil Penyertaan</a>
            </div>
        </div>
    </div>
@endsection