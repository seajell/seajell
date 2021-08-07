@extends('layout.main')
@section('content')
    <p class="fs-2">Tambah Sijil</p>
    @if(session()->has('addUserSuccess'))
        <div class="alert alert-success w-75 ml-1">{{ session('addUserSuccess') }}</div>
    @endif
    @error('userExisted')
        <div class="alert alert-danger w-75 ml-1">{{ $message }}</div>
    @enderror
    <form action="" method="post" class="mb-3">
        @csrf
        <div class="mb-3">
            <div class="row">
                <label for="username" class="form-label">Username Pengguna</label>   
            </div>
            <div class="row">
                <div class="col-11">
                    <input type="text" class="form-control w-100" id="username" name="username" placeholder="Masukkan username pengguna." value="{{ old('username') }}">
                </div>
                <div class="col-1">
                    <button type="button" id="username-search" class="btn btn-dark w-100"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </div>
        {{-- @error('username')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror --}}
        <div class="my-1" id="user-search-status">
        </div>
        <div class="mb-3 border border-dark border-3">
            <div class="row my-1 mx-1">
                <p class="fw-bold">Nama Peserta: <span class="fw-normal" id="participant-fullname-text"></span></p>
                <p class="fw-bold">No. Kad Pengenalan: <span class="fw-normal" id="participant-identification-number-text"></span></p>
            </div>
        </div>
        <div class="mb-3">
            <div class="row">
                <label for="event-id" class="form-label">ID Acara</label>   
            </div>
            <div class="row">
                <div class="col-11">
                    <input type="text" class="form-control w-100" id="event-id" name="event-id" placeholder="Masukkan ID acara." value="{{ old('event-id') }}">
                </div>
                <div class="col-1">
                    <button type="button" id="event-search" class="btn btn-dark w-100"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </div>
        {{-- @error('event-id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror --}}
        <div class="my-1" id="event-search-status">
        </div>
        <div class="mb-3 border border-dark border-3">
            <div class="row my-1 mx-1">
                <p class="fw-bold">Tarikh: <span class="fw-normal" id="event-name-text"></span></p>
                <p class="fw-bold">Tarikh: <span class="fw-normal" id="event-date-text"></span></p>
                <p class="fw-bold">Lokasi: <span class="fw-normal" id="event-location-text"></span></p>
                <p class="fw-bold">Nama Penganjur: <span class="fw-normal" id="event-organiser-name-text"></span></p>
                <p class="fw-bold">Nama Institusi: <span class="fw-normal" id="event-institute-name-text"></span></p>
                <p class="fw-bold">Keterlihatan: <span class="fw-normal" id="event-visibility-text"></span></p>
            </div>
        </div>
        <button class="btn btn-dark" type="submit">Tambah Sijil</button>
    </form>
    <script src="{{ asset('js/addCertificateSearch.js') }}"></script>
@endsection