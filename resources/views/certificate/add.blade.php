{{-- Copyright (c) 2021 Muhammad Hanis Irfan bin Mohd Zaid

This file is part of SeaJell.

SeaJell is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

SeaJell is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with SeaJell.  If not, see <https://www.gnu.org/licenses/>. --}}

@extends('layout.main')
@section('content')
    <p class="fs-2">Tambah Sijil</p>
    @if(session()->has('addCertificateSuccess'))
        <span><div class="alert alert-success w-100 ml-1">{{ session('addCertificateSuccess') }}</div></span>
    @endif
    <form action="" method="post" class="mb-5">
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
                    <button type="button" id="username-search" class="btn btn-outline-light w-100"><i class="bi bi-search"></i></button>
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
                    <button type="button" id="event-search" class="btn btn-outline-light w-100"><i class="bi bi-search"></i></button>
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
                <p class="fw-bold">Nama: <span class="fw-normal" id="event-name-text"></span></p>
                <p class="fw-bold">Tarikh: <span class="fw-normal" id="event-date-text"></span></p>
                <p class="fw-bold">Lokasi: <span class="fw-normal" id="event-location-text"></span></p>
                <p class="fw-bold">Nama Penganjur: <span class="fw-normal" id="event-organiser-name-text"></span></p>
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
            <label for="position" class="form-label">Kedudukan (Diperlukan)</label>
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
        <div class="my-3">
            <label for="category" class="form-label">Kategori (Pilihan)</label>
            <input type="text" class="form-control" id="category" name="category" placeholder="Masukkan kategori sijil." value="{{ old('category') }}">
        </div>
        @error('category')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div id="category_help mb-3" class="form-text">
            Kategori untuk pertandingan yang disertai peserta.
        </div>
        <button class="btn btn-outline-light mt-3" type="submit">Tambah Sijil</button>
    </form>
    <form action="{{ route('certificate.add.bulk') }}" method="post" class="mb-3" enctype="multipart/form-data">
        @csrf
        <p class="fs-4">Tambah Sijil Secara Pukal</p>
        <p>Anda hanya boleh menambah 500 sijil bagi acara yang sama pada satu-satu masa.</p>
        <p>Pastikan acara dan username pengguna yang dimasukkan wujud.</p>
        <p>Dapatkan templat dengan menekan butang muat turun di bawah.</p>
        <a href="{{ asset('storage/template/Template_Certificate_ms_MY.xlsx') }}" class="btn btn-outline-light"><i class="bi bi-download"></i> Muat Turun Templat</a>
        <div class="my-3">
            <label for="certificate_list" class="form-label">Fail Senarai Sijil</label>
            <input class="form-control" type="file" id="certificate_list" name="certificate_list">
        </div>
        @if(session()->has('spreadsheetSuccess'))
            <span><div class="alert alert-success w-100 ml-1">{{ session('spreadsheetSuccess') }}</div></span>
        @endif
        @error('certificate_list')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @error('sheetEventEmpty')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @error('sheetEventNotFound')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @error('sheetAtleastOne')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @if(session()->has('spreadsheetErr'))
            @if(count(session('spreadsheetErr')) > 0)
                <div class="my-3 alert alert-danger">
                    <p class="fw-bold">Ralat ({{ count(session('spreadsheetErr')) }}):</p>
                    <button class="btn btn-outline-danger" type="button" data-bs-toggle="collapse" data-bs-target="#errorCollapse" aria-expanded="false" aria-controls="errorCollapse"><i class="bi bi-arrows-expand"></i> Senarai Ralat</button>
                    <div class="collapse mt-3" id="errorCollapse">
                        <div class="card card-body">
                            @for ($i = 0; $i < count(session('spreadsheetErr')); $i++)
                                <p class="mt-1">{{ $i + 1 . ": " }}{{ session('spreadsheetErr')[$i] }}</p>
                            @endfor
                        </div>
                    </div>
                </div>
            @endif
        @endif
        <button class="btn btn-outline-light mb-3" type="submit">Tambah Sijil Secara Pukal</button>
    </form>
    <script src="{{ asset('js/addCertificateSearch.js') }}"></script>
@endsection