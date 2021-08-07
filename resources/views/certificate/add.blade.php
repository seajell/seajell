@extends('layout.main')
@section('content')
    <p class="fs-2">Tambah Sijil</p>
    @if(session()->has('addCertificateSuccess'))
        <span><div class="alert alert-success w-100 ml-1">{{ session('addCertificateSuccess') }}</div></span>
    @endif
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
        @error('username')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
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
        @error('event-id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
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
        <label class="form-label mt-1">Jenis Sijil (Pilih Satu)</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="certificate-type" id="certificate-type" value="participation" checked>
            <label class="form-check-label" for="certificate-type">
              Penyertaan
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="certificate-type" id="certificate-type" value="achievement" >
            <label class="form-check-label" for="certificate-type">
              Pencapaian
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="certificate-type" id="certificate-type" value="appreciation" >
            <label class="form-check-label" for="certificate-type">
              Penghargaan
            </label>
        </div>
        <div id="certification_type_help mb-3" class="form-text">
            Penyertaan: Untuk penyertaan sesuatu acara. <br>
            Pencapaian: Jika seseorang mendapat sebarang pencapaian. Contoh: Tempat pertama dalam sesebuah pertandingan. <br>
            Penghargaan: Diberikan kepada seseorang yang membantu dalam menjayakan acara. Contoh: Ahli Jawatankuasa Pertandingan.
        </div>
        <div class="my-3">
            <label for="position" class="form-label">Posisi</label>
            <input type="text" class="form-control" id="position" name="position" placeholder="Masukkan posisi peserta." value="{{ old('position') }}">
        </div>
        @error('position')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div id="position_help mb-3" class="form-text">
            Sijil Penyertaan. Contoh: "Peserta". <br>
            Sijil Pencapaian. Contoh: "Tempat Pertama", "Tempat Kedua", "Tempat Ketiga". <br>
            Sijil Penghargaan. Contoh: "Ahli Jawatankuasa", "Setiusaha".
        </div>
        <button class="btn btn-dark mt-3" type="submit">Tambah Sijil</button>
    </form>
    <script src="{{ asset('js/addCertificateSearch.js') }}"></script>
@endsection