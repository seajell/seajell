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
    <style type="text/css">
        @import url({{ asset('css/fonts.css') }});
    </style>
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
        @php
            if(!empty(old('certificate-orientation'))){
                switch (old('certificate-orientation')) {
                    case 'L':
                        $orientationSelectedPotrait = '';
                        $orientationSelectedLandscape = 'selected';
                        break;
                    case 'P':
                        $orientationSelectedPotrait = 'selected';
                        $orientationSelectedLandscape = '';
                        break;
                    default:
                        $orientationSelectedPotrait = 'selected';
                        $orientationSelectedLandscape = '';
                        break;
                }
            }else{
                $orientationSelectedPotrait = 'selected';
                $orientationSelectedLandscape = '';
            }
        @endphp
        <label for="certificate-orientation" class="form-label">Orientasi (Diperlukan)</label>
        <select class="form-select mb-3" name="certificate-orientation" id="certificate-orientation" aria-label="certificate-orientation">
            <option value="P" {{ $orientationSelectedPotrait }}>Potret</option>
            <option value="L" {{ $orientationSelectedLandscape }}>Landskap</option>
        </select>
        @error('certificate-orientation')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
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
        <div class="my-3 row">
            <label for="background-image" class="form-label">Gambar Latar Belakang (Pilihan)</label>
            <div class="col-10">
                <input class="form-control" type="file" id="background-image" name="background-image">
            </div>
            <div class="col-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="checked" id="background-image-check" name="background-image-check">
                    <label class="form-check-label" for="background-image-check">
                        Ada
                    </label>
                </div>
            </div>
        </div>
        <div id="background_image_help" class="form-text">
            Gambar latar belakang mestilah menggunakan format PNG. <br>
            Resolusi latar belakang mestilah mengikut saiz kertas A4 (210mm x 297mm). Ini kerana gambar akan direngangkan mengikut saiz A4.
        </div>
        @error('background-image')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label class="form-label mt-3">Teks (Diperlukan)</label>
        {{-- Default option value for text color won't be used until my fix for color picker is fixed by the Blade UI Kit maintainer
        Refer: https://github.com/blade-ui-kit/blade-ui-kit/pull/109
        :options="['default' => '#000000']"
        --}}

        <div class="row row-cols-2 row-cols-lg-4">
            @php
                $textFontList = [
                    'architectsdaughter' => 'Architects Daughter',
                    'badscript' => 'Bad Script',
                    'bebasneue' => 'Bebas Neue',
                    'berkshireswash' => 'Berkshire Swash',
                    'carterone' => 'Carter One',
                    'cookie' => 'Cookie',
                    'fredokaone' => 'Fredoka One',
                    'kaushanscript' => 'Kaushan Script',
                    'lobster' => 'Lobster',
                    'oleoscript' => 'Oleo Script',
                    'poppins' => 'Poppins',
                    'rancho' => 'Rancho',
                    'righteous' => 'Righteous',
                    'satisfy' => 'Satisfy',
                    'ptserif' => 'PT Serif',
                    'bitter' => 'Bitter',
                    'crimsontext' => 'Crimson Text',
                    'cormorantgaramond' => 'Cormorant Garamond',
                    'quicksand' => 'Quicksand',
                    'ubuntu' => 'Ubuntu',
                    'mukta' => 'Mukta',
                    'glory' => 'Glory',
                    'allison' => 'Allison',
                    'greatvibes' => 'Great Vibes',
                    'tangerine' => 'Tangerine',
                    'nanumpenscript' => 'Nanum Pen Script',
                    'karantina' => 'Karantina ',
                    'luckiestguy' => 'Luckiest Guy',
                    'bungeeshade' => 'Bungee Shade',
                    'unifrakturmaguntia' => 'Unifraktur Maguntia',
                    'bangers' => 'Bangers',
                    'pressstart2p' => 'Press Start 2P',
                    'monoton' => 'Monoton',
                    'cinzeldecorative' => 'Cinzel Decorative',
                    'poiretone' => 'Poiret One'
                ];

                ksort($textFontList);

                function selected($data, $list){
                    $selectedDataResult = [];
                    foreach ($list as $key => $value) {
                        if($key == $data){
                            $selectedDataResult[$key] = 'selected';
                        }else{
                            $selectedDataResult[$key] = '';
                        }
                    }
                    return $selectedDataResult;
                }

                if(!empty(old('type-text-font'))){
                    $typeTextFontSelected = selected(old('type-text-font'), $textFontList);
                }elseif(!empty($eventFontData->certificate_type_text_font)){
                    $typeTextFontSelected = selected($eventFontData->certificate_type_text_font, $textFontList);
                }else{
                    $typeTextFontSelected = '';
                }

                if(!empty(old('first-text-font'))){
                    $firstTextFontSelected = selected(old('first-text-font'), $textFontList);
                }elseif(!empty($eventFontData->first_text_font)){
                    $firstTextFontSelected = selected($eventFontData->first_text_font, $textFontList);
                }else{
                    $firstTextFontSelected = '';
                }

                if(!empty(old('second-text-font'))){
                    $secondTextFontSelected = selected(old('second-text-font'), $textFontList);
                }elseif(!empty($eventFontData->second_text_font)){
                    $secondTextFontSelected = selected($eventFontData->second_text_font, $textFontList);
                }else{
                    $secondTextFontSelected = '';
                }

                if(!empty(old('verifier-text-font'))){
                    $verifierTextFontSelected = selected(old('verifier-text-font'), $textFontList);
                }elseif(!empty($eventFontData->verifier_text_font)){
                    $verifierTextFontSelected = selected($eventFontData->verifier_text_font, $textFontList);
                }else{
                    $verifierTextFontSelected = '';
                }
            @endphp
            <div class="col">
                <p>Teks Jenis Sijil</p>
                <select class="selectpicker show-tick w-100" data-live-search="true" title="Sila pilih satu font.." aria-label="text-font" name="type-text-font">
                    @foreach($textFontList as $key => $value)
                        <option value="{{ $key }}" class="sj-fonts-{{ $key }}" @isset($typeTextFontSelected[$key]) {{ $typeTextFontSelected[$key] }} @endisset >{{ $value }}</option>
                    @endforeach
                </select>
                <div class="form-floating my-3">
                    <input type="number" class="form-control" name="type-text-size" placeholder="font size" step="any" value="{{ old('type-text-size', $eventFontData->certificate_type_text_size ?? 3) }}">
                    <label for="floatingInput">Saiz Font</label>
                </div>
                @error('type-text-size')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="my-1">
                    <x-buk-color-picker name="type-text-color" class="mb-3" />
                </div>
                @error('type-text-color')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <p>Teks Pertama</p>
                <select class="selectpicker show-tick w-100" data-live-search="true" title="Sila pilih satu font.." aria-label="text-font" name="first-text-font">
                    @foreach($textFontList as $key => $value)
                        <option value="{{ $key }}" class="sj-fonts-{{ $key }}" @isset($firstTextFontSelected[$key]) {{ $firstTextFontSelected[$key] }} @endisset >{{ $value }}</option>
                    @endforeach
                </select>
                <div class="form-floating my-3">
                    <input type="number" class="form-control" name="first-text-size" placeholder="font size" step="any" value="{{ old('first-text-size', $eventFontData->first_text_size ?? 1) }}">
                    <label for="floatingInput">Saiz Font</label>
                </div>
                @error('first-text-size')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="my-1">
                    <x-buk-color-picker name="first-text-color" class="mb-3" />
                </div>
                @error('first-text-color')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <p>Teks Kedua</p>
                <select class="selectpicker show-tick w-100" data-live-search="true" title="Sila pilih satu font.." aria-label="text-font" name="second-text-font">
                    @foreach($textFontList as $key => $value)
                        <option value="{{ $key }}" class="sj-fonts-{{ $key }}" @isset($secondTextFontSelected[$key]) {{ $secondTextFontSelected[$key] }} @endisset >{{ $value }}</option>
                    @endforeach
                </select>
                <div class="form-floating my-3">
                    <input type="number" class="form-control" name="second-text-size" placeholder="font size" step="any" value="{{ old('second-text-size', $eventFontData->second_text_size ?? 1) }}">
                    <label for="floatingInput">Saiz Font</label>
                </div>
                @error('second-text-size')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="my-1">
                    <x-buk-color-picker name="second-text-color" class="mb-3" />
                </div>
                @error('second-text-color')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <p>Teks Pengesah</p>
                <select class="selectpicker show-tick w-100" data-live-search="true" title="Sila pilih satu font.." aria-label="text-font" name="verifier-text-font">
                    @foreach($textFontList as $key => $value)
                        <option value="{{ $key }}" class="sj-fonts-{{ $key }}" @isset($verifierTextFontSelected[$key]) {{ $verifierTextFontSelected[$key] }} @endisset >{{ $value }}</option>
                    @endforeach
                </select>
                <div class="form-floating my-3">
                    <input type="number" class="form-control" name="verifier-text-size" placeholder="font size" step="any" value="{{ old('verifier-text-size', $eventFontData->verifier_text_size ?? 1) }}">
                    <label for="floatingInput">Saiz Font</label>
                </div>
                @error('verifier-text-size')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="my-1">
                    <x-buk-color-picker name="verifier-text-color" class="mb-3" />
                </div>
                @error('verifier-text-color')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div id="text_help" class="form-text">
            Semua teks yang terdapat pada sistem ini boleh didapati di <a href="https://fonts.google.com" target="_blank">Google Fonts</a>. <br>
            Saiz font pada sijil menggunakan unit em. Nombor perpuluhan dibenarkan.
        </div>
        <button class="btn btn-outline-light mt-3" type="submit"><i class="bi bi-plus"></i> Tambah Acara</button>
    </form>
    <script src="{{ asset('js/checksEvent.js') }}"></script>
@endsection
