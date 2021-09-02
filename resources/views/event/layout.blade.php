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
            @php
                switch($eventData->orientation){
                    case 'P':
                        $pageOrientation = 'Potrait';
                        break;
                    case 'L':
                        $pageOrientation = 'Landskap';
                        break;
                    default:
                        $pageOrientation = 'Potrait';
                        break;
                }

                if(!empty($eventData->background_image)){
                    $backgroundImageStatus = 'Ada';
                }else{
                    $backgroundImageStatus = 'Tiada';
                }

                switch($eventData->visibility){
                    case 'public':
                        $qrCodeStatus = 'Ada';
                        break;
                    case 'hidden':
                        $qrCodeStatus = 'Tiada';
                        break;
                    default:
                        $qrCodeStatus = 'Ada';
                        break;
                }

                if(!empty($eventData->text_color)){
                    $textColorStatus = $eventData->text_color;
                }else{
                    $textColorStatus = '';
                }
            @endphp
            <p>Orientasi: <span>{{ $pageOrientation }}</span></p>
            <p>Set Font: <span>{{ $eventData->font_set }}</span></p>
            <p>Gambar Latar Belakang: <span>{{ $backgroundImageStatus }}</span></p>
            <p>Kod QR: <span>{{ $qrCodeStatus }}</span></p>
            <p>Warna Teks: <span>{{ $textColorStatus }}</span></p>
        </div>
        <div class="col-2 d-flex justify-content-center align-items-center">
            <a href="" class="btn btn-outline-light"><i class="bi bi-save"></i> Simpan</a>
        </div>
    </header>
    <main class="min-vh-100 w-100">
        <div class="d-flex justify-content-center align-items-center">
            {{-- $fontSetOne = ['cookie', 'badscript', 'bebasneue', 'bebasneue', 'poppins'];
            $fontSetTwo = ['lobster', 'poiretone', 'poppins', 'bebasneue', 'poppins'];
            $fontSetThree = ['oleoscript', 'architectsdaughter', 'righteous', 'bebasneue', 'poppins'];
            $fontSetFour = ['berkshireswash', 'satisfy', 'fredokaone', 'bebasneue', 'poppins'];
            $fontSetFive = ['kaushanscript', 'rancho', 'carterone', 'bebasneue', 'poppins']; --}}
            {{-- <div id="logo-first" style="background: url({{ asset('storage' . $eventData->logo_first) }}); background-repeat: no-repeat; background-size: 100%; height: 12em; width: 12em; position: absolute; top: 3%; left: 15%;"></div> --}}
            <div id="canvas" style="width: 210mm; height: 297mm; position: relative;">
                <img src="{{ storage_path('app/public' . $eventData->background_image) }}" alt="Background image" style="position: absolute; width: 100%; height: auto;">
                <style>
                    p{
                        margin: 0%;
                    }
        
                    @page{ 
                        margin: 0px; 
                        width: 100%;
                        height: 100%; 
                    }
                </style>
                {{-- Importing fonts --}}
                @php
                    // Index 0 =
                    // Index 1 = 
                    // Index 2 = 
                    // Index 3 = 
                    // Index 4 = 
                    $fontSetFive = [];
                    $selectedFontSet = '';
                @endphp
                @switch($eventData->font_set)
                    @case(1)
                        
                        @break
                    @case(2)
                        
                        @break
                    @case(3)
                        
                        @break
                    @case(4)
                        
                        @break
                    @case(5)
                        <style>
                            @font-face {
                                font-family: 'firstFont';
                                src: url("{{ storage_path('app/fonts/third_party_all/KaushanScript-Regular.ttf') }}") format("truetype");
                                font-weight: normal;
                                font-style: normal;
                            }
        
                            @font-face {
                                font-family: 'secondFont';
                                src: url('/fonts/Rancho-Regular.ttf') format('truetype');
                                font-style: normal;
                                font-weight: normal;
                            }
        
                            @font-face {
                                font-family: 'thirdFont';
                                src: url('/fonts/CarterOne-Regular.ttf') format('truetype');
                                font-style: normal;
                                font-weight: normal;
                            }
        
                            @font-face {
                                font-family: 'signatureFont';
                                src: url('/fonts/Poppins-Regular.ttf') format('truetype');
                                font-style: normal;
                                font-weight: normal;
                            }
        
                            @font-face {
                                font-family: 'qrCodeFont';
                                src: url('/fonts/Poppins-Regular.ttf') format('truetype');
                                font-style: normal;
                                font-weight: normal;
                            }
        
                            .details-text-type{
                                font-size: 3em; 
                                font-weight: normal;
                                font-family: 'firstFont';
                                color: <?= $eventData->text_color ?>;
                            }
        
                            .details-text-first{
                                font-size: 1.5em;
                                font-weight: normal;
                                font-family: 'secondFont';
                                color: <?= $eventData->text_color ?>;
                            }
        
                            .details-text-second{
                                font-size: 0.9em;
                                font-weight: normal;
                                font-family: 'thirdFont';
                                color: <?= $eventData->text_color ?>;
                            }
        
                            .signature-text-first{
                                font-size: 0.95em;
                                font-weight: normal;
                                font-family: 'signatureFont';
                                color: <?= $eventData->text_color ?>;
                            }
        
                            .signature-text-second{
                                font-size: 0.9em;
                                font-weight: normal;
                                font-family: 'signatureFont';
                                color: <?= $eventData->text_color ?>;
                            }
        
                            #qr-code-text{
                                font-size: 1em;
                                font-weight: normal;
                                font-family: 'qrCodeFont';
                                color: #000;
                            }
                        </style>
                        @break
                    @default
                        
                @endswitch
                @php
                    $defaultText = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum blandit eros eu turpis smmper u.'; // 100 chars
                    $defaultTextSmall = 'Lorem ipsum dolor sit amet, consectetur adipiscin.'; // 50 chars
                @endphp
                @if(!empty($eventData->logo_first))
                    <div id="logo-first" style="background: url({{ storage_path('app/public' . $eventData->logo_first) }}); background-repeat: no-repeat; background-size: 100%; height: 42mm; width: 42mm; transform: translate(-50%, 0);  position: absolute; top: 0.5%; left: 20%; z-index: 10;"></div>
                @endif
                @if(!empty($eventData->logo_second))
                    <div id="logo-second" style="background: url({{ storage_path('app/public' . $eventData->logo_second) }}); background-repeat: no-repeat; background-size: 100%; height: 42mm; width: 42mm; transform: translate(-50%, 0);  position: absolute; top: 0.5%; left: 50%; z-index: 10;"></div>
                @endif
                @if(!empty($eventData->logo_third))
                    <div id="logo-third" style="background: url({{ storage_path('app/public' . $eventData->logo_third) }}); background-repeat: no-repeat; background-size: 100%; height: 42mm; width: 42mm; transform: translate(-50%, 0);  position: absolute; top: 0.5%; left: 80%; z-index: 10;"></div>
                @endif
                <div id="details" style="height: 165mm; width: 155mm; transform: translate(-50%, 0); position: absolute; top: 15%; left: 50%; text-align: center; z-index: 10;">
                    <div id="details-type" style="margin-bottom: 0.1mm;">
                        @php
                            if(!empty($certificateData->type)){
                                switch ($certificateData->type) {
                                    case 'participation':
                                        $certificateTitle = 'Sijil Penyertaan';
                                        break;
                                    case 'achievement':
                                        $certificateTitle = 'Sijil Pencapaian';
                                        break;
                                    case 'appreciation':
                                        $certificateTitle = 'Sijil Penghargaan';
                                        break;
                                    default:
                                        $certificateTitle = 'Sijil Penyertaan';
                                        break;
                                }
                            }else{
                                $certificateTitle = 'Sijil Penyertaan';
                            }
                        @endphp
                        <p class="details-text-type" style="font-weight: bold;">{{ strtoupper($certificateTitle) }}</p>
                    </div>
                    <div id="details-intro" style="margin-bottom: 1mm;">
                        @php
                            if(!empty($certificateData->type)){
                                switch ($certificateData->type) {
                                    case 'participation':
                                        $certificateIntro = 'Adalah dengan ini diakui bahawa';
                                        break;
                                    case 'achievement':
                                        $certificateIntro = 'Setinggi-tinggi tahniah diucapkan kepada';
                                        break;
                                    case 'appreciation':
                                        $certificateIntro = 'Setinggi-tinggi penghargaan dan terima kasih kepada';
                                        break;
                                    default:
                                        $certificateIntro = 'Adalah dengan ini diakui bahawa';
                                        break;
                                }
                            }else{
                                $certificateIntro = 'Adalah dengan ini diakui bahawa';
                            }
                        @endphp
                        <p class="details-text-first">{{ $certificateIntro }}</p>
                    </div>
                    <div id="details-participant-details" style="margin-bottom: 1mm;">
                        @php
                            if(!empty($certificateData->fullname)){
                                $certificateFullname = $certificateData->fullname;
                            }else{
                                $certificateFullname = $defaultText;
                            }
        
                            if(!empty($certificateData->identification_number)){
                                $certificateIdentificationNumber = $certificateData->identification_number;
                            }else{
                                $certificateIdentificationNumber = '000000000000';
                            }
                        @endphp
                        <p style="font-weight: bold;" class="details-text-second">{{ strtoupper($certificateFullname) }}</p>
                        <p style="font-weight: bold;" class="details-text-second">({{ $certificateIdentificationNumber }})</p>
                    </div>
                    <div id="details-position" style="margin-bottom: 1mm;">
                        @php
                            if(!empty($certificateData->type)){
                                switch ($certificateData->type) {
                                    case 'participation':
                                        $certificateCredit = 'Telah menyertai';
                                        break;
                                    case 'achievement':
                                        $certificateCredit = 'Di atas pencapaian';
                                        break;
                                    case 'appreciation':
                                        $certificateCredit = 'Atas sumbangan dan komitmen sebagai';
                                        break;
                                    default:
                                        $certificateCredit = 'Telah menyertai';
                                        break;
                                }
                            }else{
                                $certificateCredit = 'Telah menyertai';
                            }
                        @endphp
                        @php
                            if(!empty($certificateData->position)){
                                $certificatePosition = $certificateData->position;
                            }else{
                                $certificatePosition = 'Lorem Ipsum';
                            }
                        @endphp
                        <p class="details-text-first">{{ $certificateCredit }}</p>
                        <p style="font-weight: bold;" class="details-text-second">{{ strtoupper($certificatePosition) }}</p>
                    </div>
                    <div id="details-event-name" style="margin-bottom: 1mm;">
                        <p class="details-text-first">Dalam</p>
                        <p style="font-weight: bold;" class="details-text-second">{{ strtoupper($eventData->name) }}</p>
                    </div>
                    @if(!empty($certificateData->category))
                        <div id="details-category" style="margin-bottom: 1mm;">
                            <p class="details-text-first">Kategori</p>
                            <p style="font-weight: bold;" class="details-text-second">{{ strtoupper($certificateData->category) }}</p>
                        </div>
                    @else
                        <div id="details-category" style="margin-bottom: 1mm;">
                            <p class="details-text-first">Kategori</p>
                            <p style="font-weight: bold;" class="details-text-second">{{ strtoupper($defaultText) }}</p>
                        </div>
                    @endif
                    <div id="details-date" style="margin-bottom: 1mm;">
                        <p class="details-text-first">Pada</p>
                        <p style="font-weight: bold;" class="details-text-second">{{ Carbon\Carbon::parse($eventData->date)->format('d/m/Y') }}</p>
                    </div>
                    <div id="details-event-location" style="margin-bottom: 1mm;">
                        <p class="details-text-first">Bertempat di</p>
                        <p style="font-weight: bold;" class="details-text-second">{{ strtoupper($eventData->location) }}</p>
                    </div>
                    <div id="details-event-organiser" style="margin-bottom: 1mm;">
                        <p class="details-text-first">Anjuran</p>
                        <p style="font-weight: bold;" class="details-text-second">{{ strtoupper($eventData->organiser_name) }}</p>
                    </div>
                </div>
                @if(!empty($eventData->signature_first))
                    <div id="signature-first" style="width: 67mm; top: 71%; left: 18%; transform: translate(-50%, 0);  position: absolute; text-align: center; z-index: 10;">
                        <div id="signature-first-image" style="background: url({{ storage_path('app/public' . $eventData->signature_first) }}); background-repeat: no-repeat; background-size: 100%; width: 90%; padding-top: 33.33%; transform: translate(-50%, 0); position: relative; left: 50%;"></div>
                        <div id="signature-first-line" style="font-weight: bold; font-size: 0.8em;">
                            <p>...............................................................</p>
                        </div>
                        <div id="signature-first-name" style="margin-bottom: 0.3mm;">
                            <p style="font-weight: bold;" class="signature-text-first">{{ strtoupper($eventData->signature_first_name) }}</p>
                        </div>
                        <div id="signature-first-position">
                            <p class="signature-text-second">{{ strtoupper($eventData->signature_first_position) }}</p>
                        </div>
                    </div>
                @endif
                @if(!empty($eventData->signature_second))
                    <div id="signature-second" style="width: 67mm; top: 71%; left: 50%; transform: translate(-50%, 0);  position: absolute; text-align: center; z-index: 10;">
                        <div id="signature-second-image" style="background: url({{ storage_path('app/public' . $eventData->signature_second) }}); background-repeat: no-repeat; background-size: 100%; width: 90%; padding-top: 33.33%; transform: translate(-50%, 0); position: relative; left: 50%;"></div>
                        <div id="signature-second-line" style="font-weight: bold; font-size: 0.8em;">
                            <p>...............................................................</p>
                        </div>
                        <div id="signature-second-name" style="margin-bottom: 0.3mm;">
                            <p style="font-weight: bold;" class="signature-text-first">{{ strtoupper($eventData->signature_second_name) }}</p>
                        </div>
                        <div id="signature-second-position">
                            <p class="signature-text-second">{{ strtoupper($eventData->signature_second_position) }}</p>
                        </div>
                    </div>
                @endif
                @if(!empty($eventData->signature_third))
                    <div id="signature-third" style="width: 67mm; top: 71%; left: 82%; transform: translate(-50%, 0);  position: absolute; text-align: center; z-index: 10;">
                        <div id="signature-third-image" style="background: url({{ storage_path('app/public' . $eventData->signature_third) }}); background-repeat: no-repeat; background-size: 100%; width: 90%; padding-top: 33.33%; transform: translate(-50%, 0); position: relative; left: 50%;"></div>
                        <div id="signature-third-line" style="font-weight: bold; font-size: 0.8em;">
                            <p>...............................................................</p>
                        </div>
                        <div id="signature-third-name" style="margin-bottom: 0.3mm;">
                            <p style="font-weight: bold;" class="signature-text-first">{{ strtoupper($eventData->signature_third_name) }}</p>
                        </div>
                        <div id="signature-third-position">
                            <p class="signature-text-second">{{ strtoupper($eventData->signature_third_position) }}</p>
                        </div>
                    </div>
                @endif
                @if(!empty($eventData->visibility))
                    @if($eventData->visibility == 'public')
                        <div id="qr-code" style="margin-bottom: 10mm; height: 28mm; width: 80mm; position: absolute; top: 90%; left: 79%; transform: translate(-50%, 0); border: 1mm solid black; z-index: 10; background: #fff;">
                            <div id="qr-code-text" style="margin: 0.5mm; width: 65%; height: 96%;">
                                <div style="width: 100%; height: 100%; margin: 0.5mm;">
                                    <p style="font-weight: bold;">Imbas Kod QR Ini Untuk Menyemak Ketulenan</p>
                                    <p style="margin-top: 1mm; font-weight: bold;">ID Sijil: AAAA0000</p>
                                </div>
                            </div>
                            <div id="qr-code-image" style="background: #000; background-repeat: no-repeat; background-size: 100%; width: 25mm; height: 25mm; position: absolute; top: 3%; left: 67%;"></div>
                        </div>
                    @endif
                @endif
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