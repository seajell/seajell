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
    <p>Jika tiada sebarang perubahan pada gambar-gambar, maka gambar lama akan digunakan.</p>
    <p>Pastikan anda membuat semakan sebelum menekan butang kemas kini.</p>
    @if(session()->has('updateEventSuccess'))
        <span><div class="alert alert-success w-100 ml-1">{{ session('addEventSuccess') }}</div></span>
    @endif
    @php
        if(!empty(old('event-name'))){ 
            $valueEventName = old('event-name');
        }else{
            if(!empty($data)){
                if(!empty($data->name)){
                    $valueEventName = strtoupper($data->name);
                }else{
                    $valueEventName = "";
                }
            }else{
                $valueEventName = "";
            }
        }

        if(!empty(old('event-data'))){ 
            $valueEventDate = old('event-date');
        }else{
            if(!empty($data)){
                if(!empty($data->date)){
                    $valueEventDate = strtoupper($data->date);
                }else{
                    $valueEventDate = "";
                }
            }else{
                $valueEventDate = "";
            }
        }

        if(!empty(old('event-location'))){ 
            $valueEventLocation = old('event-location');
        }else{
            if(!empty($data)){
                if(!empty($data->location)){
                    $valueEventLocation = strtoupper($data->location);
                }else{
                    $valueEventLocation = "";
                }
            }else{
                $valueEventLocation = "";
            }
        }

        if(!empty(old('organiser-name'))){ 
            $valueOrganiserName = old('organiser-name');
        }else{
            if(!empty($data)){
                if(!empty($data->organiser_name)){
                    $valueOrganiserName = strtoupper($data->organiser_name);
                }else{
                    $valueOrganiserName = "";
                }
            }else{
                $valueOrganiserName = "";
            }
        }

        if(!empty(old('signature-first-name'))){ 
            $valueSignatureNameFirst = old('signature-first-name');
        }else{
            if(!empty($data)){
                if(!empty($data->signature_first_name)){
                    $valueSignatureNameFirst = strtoupper($data->signature_first_name);
                }else{
                    $valueSignatureNameFirst = "";
                }
            }else{
                $valueSignatureNameFirst = "";
            }
        }

        if(!empty(old('signature-first-position'))){ 
            $valueSignaturePositionFirst = old('signature-first-position');
        }else{
            if(!empty($data)){
                if(!empty($data->signature_first_position)){
                    $valueSignaturePositionFirst = strtoupper($data->signature_first_position);
                }else{
                    $valueSignaturePositionFirst = "";
                }
            }else{
                $valueSignaturePositionFirst = "";
            }
        }

        if(!empty(old('signature-second-name'))){ 
            $valueSignatureNameSecond = old('signature-second-name');
        }else{
            if(!empty($data)){
                if(!empty($data->signature_second_name)){
                    $valueSignatureNameSecond = strtoupper($data->signature_second_name);
                }else{
                    $valueSignatureNameSecond = "";
                }
            }else{
                $valueSignatureNameSecond = "";
            }
        }

        if(!empty(old('signature-second-position'))){ 
            $valueSignaturePositionSecond = old('signature-second-position');
        }else{
            if(!empty($data)){
                if(!empty($data->signature_second_position)){
                    $valueSignaturePositionSecond = strtoupper($data->signature_second_position);
                }else{
                    $valueSignaturePositionSecond = "";
                }
            }else{
                $valueSignaturePositionSecond = "";
            }
        }

        if(!empty(old('signature-third-name'))){ 
            $valueSignatureNameThird = old('signature-third-name');
        }else{
            if(!empty($data)){
                if(!empty($data->signature_third_name)){
                    $valueSignatureNameThird = strtoupper($data->signature_third_name);
                }else{
                    $valueSignatureNameThird = "";
                }
            }else{
                $valueSignatureNameThird = "";
            }
        }

        if(!empty(old('signature-third-position'))){ 
            $valueSignaturePositionThird = old('signature-third-position');
        }else{
            if(!empty($data)){
                if(!empty($data->signature_third_position)){
                    $valueSignaturePositionThird = strtoupper($data->signature_third_position);
                }else{
                    $valueSignaturePositionThird = "";
                }
            }else{
                $valueSignaturePositionThird = "";
            }
        }

        if(!empty(old('text-color'))){ 
            $valueTextColor = old('text-color');
        }else{
            if(!empty($data)){
                if(!empty($data->text_color)){
                    $valueTextColor = strtoupper($data->text_color);
                }else{
                    $valueTextColor = "";
                }
            }else{
                $valueTextColor = "";
            }
        }

        if(!empty(old('border-color'))){ 
            $valueBorderColor = old('border-color');
        }else{
            if(!empty($data)){
                if(!empty($data->border_color)){
                    $valueBorderColor = strtoupper($data->border_color);
                }else{
                    $valueBorderColor = "";
                }
            }else{
                $valueBorderColor = "";
            }
        }

    @endphp
    <form action="" method="post" class="mb-3" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="event-id" value="{{ $data->id }}">
        <div class="mb-3">
            <label for="event-name" class="form-label">Nama Acara</label>
            <input type="text" class="form-control" id="event-name" name="event-name" placeholder="Masukkan nama acara." value="{{ $valueEventName }}">
        </div>
        @error('event-name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="event-date" class="form-label">Tarikh Acara</label>
            <input type="date" class="form-control" id="event-date" name="event-date" placeholder="Masukkan tarikh acara." value="{{ $valueEventDate }}">
        </div>
        @error('event-date')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="event-location" class="form-label">Lokasi Acara</label>
            <input type="text" class="form-control" id="event-location" name="event-location" placeholder="Masukkan lokasi acara." value="{{ $valueEventLocation }}">
        </div>
        @error('event-location')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="my-3">
            <label for="organiser-name" class="form-label">Nama Penganjur</label>
            <input type="text" class="form-control" id="organiser-name" name="organiser-name" placeholder="Masukkan nama penganjur." value="{{ $valueOrganiserName }}">
        </div>
        @error('organiser-name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <hr>

        <p class="fs-5">Logo</p>
        @if(Storage::disk('public')->exists($data->logo_first))
            <img class="img-thumbnail" style="width: 7em; height: 7em;" src="{{ asset('storage' . $data->logo_first) }}" alt="Logo 1">
        @endif
        <div class="mb-3">
            <label for="logo-first" class="form-label">Logo Pertama (Diperlukan)</label>
            <input class="form-control" type="file" id="logo-first" name="logo-first">
        </div>
        @error('logo-first')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @if(Storage::disk('public')->exists($data->logo_second))
            <img class="img-thumbnail" style="width: 7em; height: 7em;" src="{{ asset('storage' . $data->logo_second) }}" alt="Logo 2">
        @endif
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
        @if(Storage::disk('public')->exists($data->logo_third))
            <img class="img-thumbnail" style="width: 7em; height: 7em;" src="{{ asset('storage' . $data->logo_third) }}" alt="Logo 3">
        @endif
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
            Gambar <span class="fst-italic">transparent</span> lebih digalakkan.
        </div>

        <hr>

        <p class="fs-5">Pengesahan</p>
        {{-- First Signature --}}
        <div class="my-3">
            <label for="signature-first-name" class="form-label">Nama Pengesah Pertama (Diperlukan)</label>
            <input type="text" class="form-control" id="signature-first-name" name="signature-first-name" placeholder="Masukkan nama pengesah." value="{{ $valueSignatureNameFirst }}">
        </div>
        @error('signature-first-name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="my-3">
            <label for="signature-first-position" class="form-label">Jawatan Pengesah Pertama (Diperlukan)</label>
            <input type="text" class="form-control" id="signature-first-position" name="signature-first-position" placeholder="Masukkan jawatan pengesah." value="{{ $valueSignaturePositionFirst }}">
        </div>
        @error('signature-first-position')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @if(Storage::disk('public')->exists($data->signature_first))
            <img class="img-thumbnail" style="width: 12em; height: 4em;" src="{{ asset('storage' . $data->signature_first) }}" alt="Signature 1">
        @endif
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
                <input type="text" class="form-control" id="signature-second-name" name="signature-second-name" placeholder="Masukkan nama pengesah." value="{{ $valueSignatureNameSecond }}">
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
            <input type="text" class="form-control" id="signature-second-position" name="signature-second-position" placeholder="Masukkan jawatan pengesah." value="{{ $valueSignaturePositionSecond }}">
        </div>
        @error('signature-second-position')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @if(Storage::disk('public')->exists($data->signature_second))
            <img class="img-thumbnail" style="width: 12em; height: 4em;" src="{{ asset('storage' . $data->signature_second) }}" alt="Signature 2">
        @endif
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
                <input type="text" class="form-control" id="signature-third-name" name="signature-third-name" placeholder="Masukkan nama pengesah." value="{{ $valueSignatureNameThird }}">
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
            <input type="text" class="form-control" id="signature-third-position" name="signature-third-position" placeholder="Masukkan jawatan pengesah." value="{{ $valueSignaturePositionThird }}">
        </div>
        @error('signature-third-position')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @if(Storage::disk('public')->exists($data->signature_third))
            <img class="img-thumbnail" style="width: 12em; height: 4em;" src="{{ asset('storage' . $data->signature_third) }}" alt="Signature 3">
        @endif
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
            Anda boleh menjana gambar tandatangan di laman <a href="{{ route('signature') }}">tandatangan</a>.
        </div>
        
        <hr>
        <p class="fs-5">Penyesuaian Gaya Sijil </p>
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
        <x-buk-color-picker name="text-color" class="mb-3" :options='["theme" => "classic", "default" => "${valueTextColor}"]' />
        <div id="text_color_help" class="form-text">
            Kesemua teks pada sijil akan diubah kepada warna ini kecuali teks pada kod QR.
        </div>
        @error('text-color')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label class="form-label mt-3"><span class="fst-italic">Border</span> (Diperlukan)</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="border" id="border1" value="available" checked>
            <label class="form-check-label" for="border">
              Ada
            </label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="border" value="unavailable" id="border2">
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
        <x-buk-color-picker name="border-color" class="mb-3" :options='["theme" => "classic", "default" => "${valueBorderColor}"]' />
        <div id="border_color_help" class="form-text">
            Hanya pilih jika <span class="fst-italic">Border</span> ditetapkan kepada <span class="fst-italic">Ada</span>.
        </div>
        @error('border-color')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button class="btn btn-dark mt-3" type="submit">Kemas Kini</button>
    </form>
    <script src="{{ asset('js/checksEvent.js') }}"></script>
@endsection