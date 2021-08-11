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
            Resolusi logo mestilah paling kurang 300 x 300 piksel dan bernisbah 1:1 bagi memastikan gambar yang jelas. <br>
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
            Resolusi logo mestilah paling kurang 300 x 300 piksel dan bernisbah 1:1 bagi memastikan gambar yang jelas. <br>
            Gambar <span class="fst-italic">transparent</span> lebih digalakkan.
        </div>
        @error('organiser-logo')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="my-3">
            <label for="verifier-name" class="form-label">Nama Pengesah (Diperlukan)</label>
            <input type="text" class="form-control" id="verifier-name" name="verifier-name" placeholder="Masukkan nama pengesah." value="{{ old('verifier-name') }}">
        </div>
        @error('verifier-name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="my-3">
            <label for="verifier-position" class="form-label">Jawatan Pengesah (Diperlukan)</label>
            <input type="text" class="form-control" id="verifier-position" name="verifier-position" placeholder="Masukkan jawatan pengesah." value="{{ old('verifier-position') }}">
        </div>
        @error('verifier-position')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="verifier-signature" class="form-label">Tandatangan Pengesah (Diperlukan)</label>
            <input class="form-control" type="file" id="verifier-signature" name="verifier-signature">
        </div>
        <div id="verifier_signature_help" class="form-text">
            Gambar tandatangan mestilah menggunakan format PNG. <br>
            Resolusi tandatangan mestilah paling kurang 300 x 100 piksel dan bernisbah 3:1 bagi memastikan tandatangan yang jelas. <br>
            Gambar tandatangan <span class="fst-italic">transparent</span> adalah diawajibkan.
        </div>
        @error('verifier-signature')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <hr>
        <p class="fs-5">Penyesuaian Gaya Sijil </p>
        <label class="form-label mt-3">Keterlihatan (Diperlukan)</label>
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
        <div id="visibility_help" class="form-text">
            Awam: Semua orang dapat akses kepada sijil jika mempunyai pautan sijil tersebut. <br>
            Tersembunyi: Hanya pemilik sijil dapat akses selepas log masuk.
        </div>
        @error('visibility')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="my-3">
            <label for="background-image" class="form-label">Gambar Latar Belakang (Pilihan)</label>
            <input class="form-control" type="file" id="background-image" name="background-image">
        </div>
        <div id="background_image_help" class="form-text">
            Gambar latar belakang mestilah menggunakan format PNG. <br>
            Resolusi latar belakang mestilah mengikut saiz kertas A4 (210mm x 297mm). Ini kerana gambar akan direngangkan mengikut saiz A4.
        </div>
        @error('background-image')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label class="form-label mt-3"><span class="fst-italic">Border</span> (Diperlukan)</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="border" id="border" value="available" checked>
            <label class="form-check-label" for="border">
              Ada
            </label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="border" value="unavailable" id="border">
            <label class="form-check-label" for="border">
              Tiada
            </label>
        </div>
        <div id="border_help" class="form-text">
            <span class="fst-italic">Border</span> akan dilukis pada sijil yang dijana.
        </div>
        @error('border')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label class="form-label mt-3">Warna <span class="fst-italic">Border (Pilihan)</span></label>
        <x-buk-color-picker name="border-color" class="mb-3" :options="['theme' => 'classic']" />
        <div id="border_color_help" class="form-text">
            Hanya pilih jika <span class="fst-italic">Border</span> ditetapkan kepada <span class="fst-italic">Ada</span>.
        </div>
        @error('border-color')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button class="btn btn-dark mt-3" type="submit">Tambah Acara</button>
    </form>
@endsection