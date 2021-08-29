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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="e-Certificate Powered by SeaJell">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('bootstraps-icons/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @if(!empty($systemSetting->logo))
        <link rel="shortcut icon" href="{{ asset('storage/') . $systemSetting->logo }}" type="image/png">
    @else
        <link rel="shortcut icon" href="{{ asset('/storage/logo/SeaJell-Logo.png') }}" type="image/png">
    @endif
    <meta name="api-token" content="{{ $apiToken }}">
    <title>
        @if(!empty($systemSetting->name))
            {{ strtoupper($systemSetting->name) }}
        @else
            {{ 'SeaJell' }}
        @endif
        {{ '- SeaJell' }}
    </title>
    @bukStyles(true)
</head>
<body style="background-color: #495057">
    <header class="bg-dark w-100 row g-0 text-light py-3">
        <div class="col-10 row row-cols-lg-3 row-cols-1 g-0">
            <p>Orientasi: </p>
            <p>Set Font: </p>
            <p>Gambar Latar Belakang: </p>
            <p>Kod QR: </p>
            <p>Warna Teks: </p>
        </div>
        <div class="col-2 d-flex justify-content-center align-items-center">
            <a href="" class="btn btn-outline-light"><i class="bi bi-save"></i> Simpan</a>
        </div>
    </header>
    <main class="min-vh-100 w-100">
        <div class="d-flex justify-content-center align-items-center">
            {{-- <div id="logo-first" style="background: url({{ asset('storage' . $data->logo_first) }}); background-repeat: no-repeat; background-size: 100%; height: 12em; width: 12em; position: absolute; top: 3%; left: 15%;"></div> --}}
            <div id="canvas" style="background: #fff; height: 99vw; width: 70vw; position: relative;">
                <style>
                    p{
                        margin: 0%;
                    }

                    .details-text-type{
                        font-size: 2.5em; 
                        font-weight: bold;
                    }

                    .details-text-first{
                        font-size: 1em;
                    }

                    .details-text-second{
                        font-size: 1.1em;
                    }

                    .signature-text{
                        font-size: 1em;
                    }
                </style>
                <div id="logo-first" style="background: #000; background-repeat: no-repeat; background-size: 100%; height: 12em; width: 12em; position: absolute; top: 1%; left: 15%;"></div>
                <div id="logo-second" style="background: #000; background-repeat: no-repeat; background-size: 100%; height: 12em; width: 12em; position: absolute; top: 1%; left: 41%;"></div>
                <div id="logo-third" style="background: #000; background-repeat: no-repeat; background-size: 100%; height: 12em; width: 12em; position: absolute; top: 1%; left: 67%;"></div>
                <div id="details" style="height: 44em; width: 40em; position: absolute; top: 16%; left: 20%; text-align: center;">
                    @php
                        $defaultText = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum blandit eros eu turpis semper ultrices. Ut porta turpis fusce.';
                    @endphp
                    <div id="details-type" style="margin-bottom: 0.1em;">
                        <p class="details-text-type">Sijil Pencapaian</p>
                    </div>
                    <div id="details-intro" style="margin-bottom: 1em;">
                        <p class="details-text-first">Setinggi-tinggi tahniah diucapkan kepada</p>
                    </div>
                    <div id="details-participant-details" style="margin-bottom: 1em;">
                        <p style="font-weight: bold;" class="details-text-second">{{ $defaultText }}</p>
                        <p style="font-weight: bold;" class="details-text-second">(0000000000)</p>
                    </div>
                    <div id="details-position" style="margin-bottom: 1em;">
                        <p class="details-text-first">Di atas pencapaian</p>
                        <p style="font-weight: bold;" class="details-text-second">Tempat Pertama</p>
                    </div>
                    <div id="details-event-name" style="margin-bottom: 1em;">
                        <p class="details-text-first">Dalam</p>
                        <p style="font-weight: bold;" class="details-text-second">{{ $defaultText }}</p>
                    </div>
                    <div id="details-category" style="margin-bottom: 1em;">
                        <p class="details-text-first">Kategori</p>
                        <p style="font-weight: bold;" class="details-text-second">{{ $defaultText }}</p>
                    </div>
                    <div id="details-date" style="margin-bottom: 1em;">
                        <p class="details-text-first">Pada</p>
                        <p style="font-weight: bold;" class="details-text-second">00/00/0000</p>
                    </div>
                    <div id="details-event-location" style="margin-bottom: 1em;">
                        <p class="details-text-first">Bertempat di</p>
                        <p style="font-weight: bold;" class="details-text-second">{{ $defaultText }}</p>
                    </div>
                    <div id="details-event-organiser" style="margin-bottom: 1em;">
                        <p class="details-text-first">Anjuran</p>
                        <p style="font-weight: bold;" class="details-text-second">{{ $defaultText }}</p>
                    </div>
                </div>
                <div id="signature-first" class="signature-text" style="width: 19em; top: 68%; left: 2%; position: absolute; text-align: center;">
                    <div id="signature-first-image" style="background: #000; background-repeat: no-repeat; background-size: 100%; width: 90%; padding-top: 33.33%;"></div>
                    <div id="signature-first-line">
                        <p>...................................................................................</p>
                    </div>
                    <div id="signature-first-name" style="margin-bottom: 0.3em;">
                        {{ $defaultText }}
                    </div>
                    <div id="signature-first-position">
                        {{ $defaultText }}
                    </div>
                </div>
                <div id="signature-second" class="signature-text" style="width: 19em; top: 68%; left: 36%; position: absolute; text-align: center;">
                    <div id="signature-second-image" style="background: #000; background-repeat: no-repeat; background-size: 100%; width: 90%; padding-top: 33.33%;"></div>
                    <div id="signature-second-line">
                        <p>...................................................................................</p>
                    </div>
                    <div id="signature-second-name" style="margin-bottom: 0.3em;">
                        {{ $defaultText }}
                    </div>
                    <div id="signature-second-position">
                        {{ $defaultText }}
                    </div>
                </div>
                <div id="signature-third" class="signature-text" style="width: 19em; top: 68%; left: 69%; position: absolute; text-align: center;">
                    <div id="signature-third-image" style="background: #000; background-repeat: no-repeat; background-size: 100%; width: 90%; padding-top: 33.33%;"></div>
                    <div id="signature-third-line">
                        <p>...................................................................................</p>
                    </div>
                    <div id="signature-third-name" style="margin-bottom: 0.3em;">
                        {{ $defaultText }}
                    </div>
                    <div id="signature-third-position">
                        {{ $defaultText }}
                    </div>
                </div>
                <div id="qr-code" style="height: 6.5em; width: 21.5em; top: 92%; left: 65%; position: absolute; border: 0.3em solid black;">
                    <div id="qr-code-text" style="width: 15em; height: 6em;">
                        <p style="margin-left: 0.5em; margin-bottom: 0.7em; width: 95%;">Imbas Kod QR Ini Untuk Menyemak Ketulenan</p>
                        <p style="margin-left: 0.5em; width: 95%;">ID Sijil: AAAA0000</p>
                    </div>
                    <div id="qr-code-image" style="background: #000; background-repeat: no-repeat; background-size: 100%; width: 5.8em; height: 5.8em; position: absolute; top: 1%; left: 72%;"></div>
                </div>
            </div>
        </div>
    </main>
    <footer class="bg-dark text-center text-light pb-4">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <p class="mt-5"><a class="text-decoration-underline text-light" href="https://projects.hanisirfan.xyz/seajell" target="_blank">SeaJell</a> {{ $appVersion }}</p>
            <p>Hak Cipta &copy; <a href="http://hanisirfan.xyz" class="text-light">Muhammad Hanis Irfan bin Mohd Zaid</a> 2021</p>
        </div>
    </footer>
</body>
</html>