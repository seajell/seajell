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
        {{ $data }}
        <div class="d-flex justify-content-center align-items-center">
            {{-- $fontSetOne = ['cookie', 'badscript', 'bebasneue', 'bebasneue', 'poppins'];
            $fontSetTwo = ['lobster', 'poiretone', 'poppins', 'bebasneue', 'poppins'];
            $fontSetThree = ['oleoscript', 'architectsdaughter', 'righteous', 'bebasneue', 'poppins'];
            $fontSetFour = ['berkshireswash', 'satisfy', 'fredokaone', 'bebasneue', 'poppins'];
            $fontSetFive = ['kaushanscript', 'rancho', 'carterone', 'bebasneue', 'poppins']; --}}
            {{-- <div id="logo-first" style="background: url({{ asset('storage' . $data->logo_first) }}); background-repeat: no-repeat; background-size: 100%; height: 12em; width: 12em; position: absolute; top: 3%; left: 15%;"></div> --}}
            <div id="canvas" style="background: #fff; height: 297mm; width: 210mm; position: relative;">
                <style>
                    p{
                        margin: 0%;
                    }

                    @page{ 
                        margin: 0px; 
                    }
                </style>
                {{-- Importing fonts --}}
                @switch($data->font_set)
                    @case(1)
                        <style>
                            @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap');
                            
                            body{
                                font-family: 'Josefin Sans', sans-serif;
                            }
                        </style>
                        @break
                    @case(2)
                        <style>
                            @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap');
                            
                            body{
                                font-family: 'Josefin Sans', sans-serif;
                            }
                        </style>
                        @break
                    @case(3)
                        <style>
                            @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap');
                            
                            body{
                                font-family: 'Josefin Sans', sans-serif;
                            }
                        </style>
                        @break
                    @case(4)
                        <style>
                            @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap');
                            
                            body{
                                font-family: 'Josefin Sans', sans-serif;
                            }
                        </style>
                        @break
                    @case(5)
                        <style>
                            @font-face {
                                font-family: firstFont;
                                src: url(https://fonts.googleapis.com/css2?family=Cookie&display=swap);
                            }
                            @font-face {
                                font-family: secondFont;
                                src: url(sansation_light.woff);
                            }

                            @font-face {
                                font-family: thirdFont;
                                src: url(sansation_light.woff);
                            }

                            .details-text-type{
                                font-size: 12mm; 
                                font-weight: bold;
                                font-family: firstFont;
                            }

                            .details-text-first{
                                font-size: 4mm;
                                font-family: secondFont;
                            }

                            .details-text-second{
                                font-size: 5mm;
                                font-family: thirdFont;
                            }

                            .signature-text{
                                font-size: 4mm;
                                font-family: thirdFont;
                            }

                            #qr-code-text{
                                font-size: 4mm;
                                font-family: thirdFont;
                            }
                        </style>
                        @break
                    @default
                        <style>
                            @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap');
                            
                            body{
                                font-family: 'Josefin Sans', sans-serif;
                            }
                        </style>
                @endswitch
                @php
                    $defaultText = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum blandit eros eu turpis smmper u.';
                    $defaultTextSmall = 'Lorem ipsum dolor sit amet, consectetur adipiscin.';
                @endphp
                <div id="logo-first" style="background: #000; background-repeat: no-repeat; background-size: 100%; height: 50mm; width: 50mm; transform: translate(-50%, 0);  position: absolute; top: 0.5%; left: 20%; z-index: 10;"></div>
                <div id="logo-second" style="background: #000; background-repeat: no-repeat; background-size: 100%; height: 50mm; width: 50mm; transform: translate(-50%, 0);  position: absolute; top: 0.5%; left: 50%; z-index: 10;"></div>
                <div id="logo-third" style="background: #000; background-repeat: no-repeat; background-size: 100%; height: 50mm; width: 50mm; transform: translate(-50%, 0);  position: absolute; top: 0.5%; left: 80%; z-index: 10;"></div>
                <div id="details" style="height: 165mm; width: 200mm; transform: translate(-50%, 0); position: absolute; top: 15%; left: 50%; text-align: center; z-index: 10; background: orange;">
                    <div id="details-type" style="margin-bottom: 0.1mm;">
                        <p class="details-text-type">Sijil Pencapaian</p>
                    </div>
                    <div id="details-intro" style="margin-bottom: 1mm;">
                        <p class="details-text-first">Setinggi-tinggi tahniah diucapkan kepada</p>
                    </div>
                    <div id="details-participant-details" style="margin-bottom: 1mm;">
                        <p style="font-weight: bold;" class="details-text-second">{{ $defaultText }}</p>
                        <p style="font-weight: bold;" class="details-text-second">(0000000000)</p>
                    </div>
                    <div id="details-position" style="margin-bottom: 1mm;">
                        <p class="details-text-first">Di atas pencapaian</p>
                        <p style="font-weight: bold;" class="details-text-second">Tempat Pertama</p>
                    </div>
                    <div id="details-event-name" style="margin-bottom: 1mm;">
                        <p class="details-text-first">Dalam</p>
                        <p style="font-weight: bold;" class="details-text-second">{{ $defaultText }}</p>
                    </div>
                    <div id="details-category" style="margin-bottom: 1mm;">
                        <p class="details-text-first">Kategori</p>
                        <p style="font-weight: bold;" class="details-text-second">{{ $defaultText }}</p>
                    </div>
                    <div id="details-date" style="margin-bottom: 1mm;">
                        <p class="details-text-first">Pada</p>
                        <p style="font-weight: bold;" class="details-text-second">00/00/0000</p>
                    </div>
                    <div id="details-event-location" style="margin-bottom: 1mm;">
                        <p class="details-text-first">Bertempat di</p>
                        <p style="font-weight: bold;" class="details-text-second">{{ $defaultText }}</p>
                    </div>
                    <div id="details-event-organiser" style="margin-bottom: 1mm;">
                        <p class="details-text-first">Anjuran</p>
                        <p style="font-weight: bold;" class="details-text-second">{{ $defaultText }}</p>
                    </div>
                </div>
                <div id="signature-first" class="signature-text" style="width: 67mm; border: 0.1mm solid black; top: 71%; left: 18%; transform: translate(-50%, 0);  position: absolute; text-align: center; z-index: 10; background: grey;">
                    <div id="signature-first-image" style="background: #000; background-repeat: no-repeat; background-size: 100%; width: 90%; padding-top: 33.33%; transform: translate(-50%, 0); position: relative; left: 50%;"></div>
                    <div id="signature-first-line">
                        <hr>
                    </div>
                    <div id="signature-first-name" style="margin-bottom: 0.3mm;">
                        <p style="font-weight: bold;">{{ $defaultTextSmall }}</p>
                    </div>
                    <div id="signature-first-position">
                        <p>{{ $defaultTextSmall }}</p>
                    </div>
                </div>
                <div id="signature-second" class="signature-text" style="width: 67mm; border: 0.1mm solid black; top: 71%; left: 50%; transform: translate(-50%, 0);  position: absolute; text-align: center; z-index: 10; background: grey;">
                    <div id="signature-second-image" style="background: #000; background-repeat: no-repeat; background-size: 100%; width: 90%; padding-top: 33.33%; transform: translate(-50%, 0); position: relative; left: 50%;"></div>
                    <div id="signature-second-line">
                        <hr>
                    </div>
                    <div id="signature-second-name" style="margin-bottom: 0.3mm;">
                        <p style="font-weight: bold;">{{ $defaultTextSmall }}</p>
                    </div>
                    <div id="signature-second-position">
                        <p>{{ $defaultTextSmall }}</p>
                    </div>
                </div>
                <div id="signature-third" class="signature-text" style="width: 67mm; border: 0.1mm solid black; top: 71%; left: 82%; transform: translate(-50%, 0);  position: absolute; text-align: center; z-index: 10; background: grey;">
                    <div id="signature-third-image" style="background: #000; background-repeat: no-repeat; background-size: 100%; width: 90%; padding-top: 33.33%; transform: translate(-50%, 0); position: relative; left: 50%;"></div>
                    <div id="signature-third-line">
                        <hr>
                    </div>
                    <div id="signature-third-name" style="margin-bottom: 0.3mm;">
                        <p style="font-weight: bold;">{{ $defaultTextSmall }}</p>
                    </div>
                    <div id="signature-third-position">
                        <p>{{ $defaultTextSmall }}</p>
                    </div>
                </div>
                <div id="qr-code" style="margin-bottom: 10mm; height: 28mm; width: 80mm; top: 90%; left: 76%; transform: translate(-50%, 0);  position: absolute; border: 1mm solid black; z-index: 10;">
                    <div id="qr-code-text" style="margin: 0.5mm; width: 65%; height: 96%;">
                        <div style="width: 100%; height: 100%; margin: 0.5mm;">
                            <p>Imbas Kod QR Ini Untuk Menyemak Ketulenan</p>
                            <p style="margin-top: 1mm;">ID Sijil: AAAA0000</p>
                        </div>
                    </div>
                    <div id="qr-code-image" style="background: #000; background-repeat: no-repeat; background-size: 100%; width: 25mm; height: 25mm; position: absolute; top: 3%; left: 67%;"></div>
                </div>
                <div style="border: 0.5mm solid black; height: 297mm; width: 105mm; top: 0%; left: 0%; position: absolute; background: red; z-index: 1;"></div>
                <div style="border: 0.5mm solid black; height: 297mm; width: 105mm; top: 0%; left: 50%; position: absolute; background: blue; z-index: 1;"></div>
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