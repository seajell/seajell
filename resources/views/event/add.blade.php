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
        <div class="my-3">
            <label for="organiser-name" class="form-label">Nama Penganjur</label>
            <input type="text" class="form-control" id="organiser-name" name="organiser-name" placeholder="Masukkan nama penganjur." value="{{ old('organiser-name') }}">
        </div>
        @error('organiser-name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <hr>
        <p class="fs-5">Logo</p>
        <div class="mb-3">
            <label for="logo-first" class="form-label">Logo Pertama (Diperlukan)</label>
            <input class="form-control" type="file" id="logo-first" name="logo-first">
        </div>
        @error('logo-first')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3 row">
            <label for="logo-second" class="form-label">Logo Kedua (Pilihan)</label>
            <div class="col-10">
                <input class="form-control" type="file" id="logo-second" name="logo-second">
            </div>
            <div class="col-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="logo-second-check">
                    <label class="form-check-label" for="logo-second-check">
                        Ada
                    </label>
                </div>
            </div>
        </div>
        @error('logo-second')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3 row">
            <label for="logo-third" class="form-label">Logo Ketiga (Pilihan)</label>
            <div class="col-10">
                <input class="form-control" type="file" id="logo-third" name="logo-third">
            </div>
            <div class="col-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="logo-third-check">
                    <label class="form-check-label" for="logo-third-check">
                        Ada
                    </label>
                </div>
            </div>
        </div>
        @error('logo-third')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div id="logo_help" class="form-text">
            Logo mestilah menggunakan format PNG. <br>
            Resolusi logo mestilah paling kurang 300 x 300 piksel dan bernisbah 1:1 bagi memastikan gambar yang jelas. <br>
            Gambar <span class="fst-italic">transparent</span> lebih digalakkan. <br>
            Jika anda memasukkan logo di ruangan ketiga tanpa memasukkan logo diruangan kedua, maka logo tersebut akan dikira sebagai logo yang dimasukkan pada ruangan kedua.
        </div>

        <hr>
        <p class="fs-5">Pengesahan</p>
        {{-- First Signature --}}
        <div class="my-3">
            <label for="signature-first-name" class="form-label">Nama Pengesah Pertama (Diperlukan)</label>
            <input type="text" class="form-control" id="signature-first-name" name="signature-first-name" placeholder="Masukkan nama pengesah." value="{{ old('signature-first-name') }}">
        </div>
        @error('signature-first-name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="my-3">
            <label for="signature-first-position" class="form-label">Jawatan Pengesah Pertama (Diperlukan)</label>
            <input type="text" class="form-control" id="signature-first-position" name="signature-first-position" placeholder="Masukkan jawatan pengesah." value="{{ old('signature-first-position') }}">
        </div>
        @error('signature-first-position')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="signature-first" class="form-label">Tandatangan Pengesah Pertama (Diperlukan)</label>
            <input class="form-control" type="file" id="signature-first" name="signature-first">
        </div>
        @error('signature-first')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        {{-- Second Signature --}}
        <div class="my-3 row">
            <label for="signature-second-name" class="form-label">Nama Pengesah Kedua (Pilihan)</label>
            <div class="col-10">
                <input type="text" class="form-control" id="signature-second-name" name="signature-second-name" placeholder="Masukkan nama pengesah." value="{{ old('signature-second-name') }}">
            </div>
            <div class="col-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="signature-second-check">
                    <label class="form-check-label" for="signature-second-check">
                        Ada
                    </label>
                </div>
            </div>
        </div>
        @error('signature-second-name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="my-3">
            <label for="signature-second-position" class="form-label">Jawatan Pengesah Kedua (Pilihan)</label>
            <input type="text" class="form-control" id="signature-second-position" name="signature-second-position" placeholder="Masukkan jawatan pengesah." value="{{ old('signature-second-position') }}">
        </div>
        @error('signature-second-position')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="signature-second" class="form-label">Tandatangan Pengesah Kedua (Pilihan)</label>
            <input class="form-control" type="file" id="signature-second" name="signature-second">
        </div>
        @error('signature-second')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        {{-- Third Signature --}}
        <div class="my-3 row">
            <label for="signature-third-name" class="form-label">Nama Pengesah Ketiga (Pilihan)</label>
            <div class="col-10">
                <input type="text" class="form-control" id="signature-third-name" name="signature-third-name" placeholder="Masukkan nama pengesah." value="{{ old('signature-third-name') }}">
            </div>
            <div class="col-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="signature-third-check">
                    <label class="form-check-label" for="signature-third-check">
                        Ada
                    </label>
                </div>
            </div>
        </div>
        @error('signature-third-name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="my-3">
            <label for="signature-third-position" class="form-label">Jawatan Pengesah Ketiga (Pilihan)</label>
            <input type="text" class="form-control" id="signature-third-position" name="signature-third-position" placeholder="Masukkan jawatan pengesah." value="{{ old('signature-third-position') }}">
        </div>
        @error('signature-third-position')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="signature-third" class="form-label">Tandatangan Pengesah Ketiga (Pilihan)</label>
            <input class="form-control" type="file" id="signature-third" name="signature-third">
        </div>
        @error('signature-third')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div id="signature_help" class="form-text">
            Gambar tandatangan mestilah menggunakan format PNG. <br>
            Resolusi tandatangan mestilah paling kurang 300 x 100 piksel dan bernisbah 3:1 bagi memastikan tandatangan yang jelas. <br>
            Gambar tandatangan <span class="fst-italic">transparent</span> adalah diwajibkan. <br>
            Anda boleh menjana gambar tandatangan di laman <a href="{{ route('signature') }}">tandatangan</a>. <br>
            Jika anda memasukkan maklumat pengesah di ruangan ketiga tanpa memasukkan maklumat pengesah diruangan kedua, maka maklumat pengesah tersebut akan dikira sebagai maklumat pengesah yang dimasukkan pada ruangan kedua.
        </div>
        
        <hr>
        <p class="fs-5">Penyesuaian Gaya Sijil </p>
        <label for="role" class="form-label">Set Font</label>
        <select class="form-select mb-3" name="font-set" id="font-set" aria-label="font-set">
            <option value="1">Set 1</option>
            <option value="2">Set 2</option>
            <option value="3">Set 3</option>
            <option value="4">Set 4</option>
            <option value="5">Set 5</option>
        </select>
        @error('font-set')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div id="form_set_help" class="form-text">
            <p>Set font ini menentukan font yang akan digunakan pada sijil. Lihat contoh hasil daripada set font di bawah:</p>
            <ul>
                <li><a href="{{ asset('storage/fontset/1/1.pdf') }}" target="_blank">Set 1</a></li>
                <li><a href="{{ asset('storage/fontset/2/2.pdf') }}" target="_blank">Set 2</a></li>
                <li><a href="{{ asset('storage/fontset/3/3.pdf') }}" target="_blank">Set 3</a></li>
                <li><a href="{{ asset('storage/fontset/4/4.pdf') }}" target="_blank">Set 4</a></li>
                <li><a href="{{ asset('storage/fontset/5/5.pdf') }}" target="_blank">Set 5</a></li>
            </ul>
        </div>
        <label class="form-label mt-3">Keterlihatan (Diperlukan)</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="visibility" id="visibility1" value="public" checked>
            <label class="form-check-label" for="visibility">
              Awam
            </label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="visibility" value="hidden" id="visibility2">
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
        <label class="form-label mt-3">Warna Teks (Diperlukan)</label>
        <x-buk-color-picker name="text-color" class="mb-3" :options="['theme' => 'classic', 'default' => '#000000']" />
        <div id="text_color_help" class="form-text">
            Kesemua teks pada sijil akan diubah kepada warna ini kecuali teks pada kod QR.
        </div>
        @error('text-color')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label class="form-label mt-3"><span class="fst-italic">Border</span> (Diperlukan)</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="border" id="border1" value="available">
            <label class="form-check-label" for="border">
              Ada
            </label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="border" value="unavailable" id="border2" checked>
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
    <script src="{{ asset('js/checksEvent.js') }}"></script>
@endsection