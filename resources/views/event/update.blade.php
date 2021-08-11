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
    <p class="fs-2">Kemas Kini Acara</p>
    <p>Jika anda mahu mengemaskini sebarang gambar seperti logo atau tandatangan, muat naik gambar tersebut pada ruang yang disediakan.</p>
    @php
    //  Check if there's old value, if not insert data from database if available
        
        if(old('event-name') != NULL){ // event-name
            $valueEventName = old('event-name');
        }else{
            if($data != NULL && $data != ''){
                if($data->name != NULL && $data->name != ''){
                    $valueEventName = strtoupper($data->name);
                }else{
                    $valueEventName = "";
                }
            }else{
                $valueEventName = '';
            }
        }

        if(old('event-date') != NULL){ // event-date
            $valueEventDate = old('event-date');
        }else{
            if($data != NULL && $data != ''){
                if($data->date != NULL && $data->date != ''){
                    $valueEventDate = $data->date;
                }else{
                    $valueEventDate = "";
                }
            }else{
                $valueEventDate = '';
            }
        }

        if(old('event-location') != NULL){ // event-location
            $valueLocation = old('event-location');
        }else{
            if($data != NULL && $data != ''){
                if($data->location != NULL && $data->location != ''){
                    $valueEventLocation = strtoupper($data->location);
                }else{
                    $valueEventLocation = "";
                }
            }else{
                $valueLocation = '';
            }
        }

        if(old('institute-name') != NULL){ // institute-name
            $valueInstituteName = old('institute-name');
        }else{
            if($data != NULL && $data != ''){
                if($data->institute_name != NULL && $data->institute_name != ''){
                    $valueInstituteName = strtoupper($data->institute_name);
                }else{
                    $valueInstituteName = "";
                }
            }else{
                $valueInstituteName = '';
            }
        }

        if(old('organiser-name') != NULL){ // organiser-name
            $valueOrganiserName = old('organiser-name');
        }else{
            if($data != NULL && $data != ''){
                if($data->organiser_name != NULL && $data->organiser_name != ''){
                    $valueOrganiserName = strtoupper($data->organiser_name);
                }else{
                    $valueOrganiserName = "";
                }
            }else{
                $valueOrganiserName = '';
            }
        }

        if(old('verifier-name') != NULL){ // verifier-name
            $valueVerifierName = old('verifier-name');
        }else{
            if($data != NULL && $data != ''){
                if($data->verifier_name != NULL && $data->verifier_name != ''){
                    $valueVerifierName = strtoupper($data->verifier_name);
                }else{
                    $valueVerifierName = "";
                }
            }else{
                $valueVerifierName = '';
            }
        }

        if(old('verifier-position') != NULL){ // verifier-position
            $valueVerifierPosition = old('verifier-position');
        }else{
            if($data != NULL && $data != ''){
                if($data->verifier_position != NULL && $data->verifier_position != ''){
                    $valueVerifierPosition = strtoupper($data->verifier_position);
                }else{
                    $valueVerifierPosition = "";
                }
            }else{
                $valueVerifierPosition = '';
            }
        }

    @endphp
    @if(session()->has('updateEventSuccess'))
        <span><div class="alert alert-success w-100 ml-1">{{ session('updateEventSuccess') }}</div></span>
    @endif
    <form action="" method="post" class="mb-3" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="event-name" class="form-label">Nama Acara (Diperlukan)</label>
            <input type="text" class="form-control" id="event-name" name="event-name" placeholder="Masukkan nama acara." value="{{ $valueEventName }}">
        </div>
        @error('event-name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="event-date" class="form-label">Tarikh Acara (Diperlukan)</label>
            <input type="date" class="form-control" id="event-date" name="event-date" placeholder="Masukkan tarikh acara." value="{{ $valueEventDate }}">
        </div>
        @error('event-date')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="event-location" class="form-label">Lokasi Acara (Diperlukan)</label>
            <input type="text" class="form-control" id="event-location" name="event-location" placeholder="Masukkan lokasi acara." value="{{ $valueEventLocation }}">
        </div>
        @error('event-location')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="institute-name" class="form-label">Nama Institusi (Pilihan)</label>
            <input type="text" class="form-control" id="institute-name" name="institute-name" placeholder="Masukkan nama institusi." value="{{ $valueInstituteName }}">
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
            <input type="text" class="form-control" id="organiser-name" name="organiser-name" placeholder="Masukkan nama penganjur." value="{{ $valueOrganiserName }}">
        </div>
        @error('organiser-name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="organiser-logo" class="form-label">Logo Penganjur (Pilihan)</label>
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
            <input type="text" class="form-control" id="verifier-name" name="verifier-name" placeholder="Masukkan nama pengesah." value="{{ $valueVerifierName }}">
        </div>
        @error('verifier-name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="my-3">
            <label for="verifier-position" class="form-label">Jawatan Pengesah (Diperlukan)</label>
            <input type="text" class="form-control" id="verifier-position" name="verifier-position" placeholder="Masukkan jawatan pengesah." value="{{ $valueVerifierPosition }}">
        </div>
        @error('verifier-position')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="verifier-signature" class="form-label">Tandatangan Pengesah (Pilihan)</label>
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
        <button class="btn btn-dark mt-3" type="submit">Kemas Kini</button>
    </form>
@endsection