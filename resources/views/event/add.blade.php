@extends('layout.main')
@section('content')
    <p class="fs-2">Tambah Acara</p>
    @if(session()->has('addEventSuccess'))
        <span><div class="alert alert-success w-100 ml-1">{{ session('addEventSuccess') }}</div></span>
    @endif
    <form action="" method="post" class="mb-3" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="event-name" class="form-label">Nama Acara</label>
            <input type="text" class="form-control" id="event-name" name="event-name" placeholder="Masukkan nama acara." value="{{ old('event-name') }}">
        </div>
        @error('event-name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="event-date" class="form-label">Tarikh Acara</label>
            <input type="date" class="form-control" id="event-date" name="event-date" placeholder="Masukkan tarikh acara." value="{{ old('event-date') }}">
        </div>
        @error('event-date')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="event-location" class="form-label">Lokasi Acara</label>
            <input type="text" class="form-control" id="event-location" name="event-location" placeholder="Masukkan lokasi acara." value="{{ old('event-location') }}">
        </div>
        @error('event-location')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="institute-name" class="form-label">Nama Institusi (Pilihan)</label>
            <input type="text" class="form-control" id="institute-name" name="institute-name" placeholder="Masukkan nama institusi." value="{{ old('institute-name') }}">
        </div>
        @error('institute-name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="insititute-logo" class="form-label">Logo Institusi (Pilihan)</label>
            <input class="form-control" type="file" id="insititute-logo" name="institute-logo">
        </div>
        <div id="institute_logo_help" class="form-text">
            Logo mestilah menggunakan format PNG. <br>
            Resolusi logo mestilah paling kurang 300 x 300 piksel bagi memastikan gambar yang jelas. <br>
            Gambar <span class="fst-italic">transparent</span> lebih digalakkan.
        </div>
        @error('insititute-logo')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="my-3">
            <label for="organiser-name" class="form-label">Nama Penganjur (Diperlukan)</label>
            <input type="text" class="form-control" id="organiser-name" name="organiser-name" placeholder="Masukkan nama penganjur." value="{{ old('organiser-name') }}">
        </div>
        @error('organiser-name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="organiser-logo" class="form-label">Logo Penganjur (Diperlukan)</label>
            <input class="form-control" type="file" id="organiser-logo" name="organiser-logo">
        </div>
        <div id="organiser_logo_help" class="form-text">
            Logo mestilah menggunakan format PNG. <br>
            Resolusi logo mestilah paling kurang 300 x 300 piksel bagi memastikan gambar yang jelas. <br>
            Gambar <span class="fst-italic">transparent</span> lebih digalakkan.
        </div>
        @error('organiser-logo')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label class="form-label mt-3">Keterlihatan (Pilih Satu)</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="visibility" id="visibility" value="public" checked>
            <label class="form-check-label" for="visibility">
              Awam
            </label>
        </div>     
        <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="visibility" value="hidden" id="visibility">
            <label class="form-check-label" for="visibility">
              Tersembunyi
            </label>
        </div>
        <div id="invisibility_help" class="form-text">
            Awam: Semua orang dapat akses kepada sijil jika mempunyai pautan sijil tersebut. <br>
            Tersembunyi: Hanya pemilik sijil dapat akses selepas log masuk.
        </div>
        <button class="btn btn-dark mt-3" type="submit">Tambah Acara</button>
    </form>
@endsection