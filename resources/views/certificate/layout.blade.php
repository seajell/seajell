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
    @if(!empty($systemSetting->logo))
        <link rel="shortcut icon" href="{{ asset('storage/') . $systemSetting->logo }}" type="image/png">
    @else
        <link rel="shortcut icon" href="{{ asset('/storage/logo/SeaJell-Logo.png') }}" type="image/png">
    @endif
    <title>
        @if(!empty($systemSetting->name))
            {{ strtoupper($systemSetting->name) }}
        @else
            {{ 'SeaJell' }}
        @endif
        {{ '- Certificate Viewer' }}
    </title>
</head>
<body>
    {{-- Page Orientation --}}
    @php
        switch($eventData->orientation){
            case 'P':
                $backgroundImageWidth = '210mm';
                $backgroundImageHeight = '297mm';
                break;
            case 'L':
                $backgroundImageWidth = '297mm';
                $backgroundImageHeight = '210mm';
                break;
            default:
                $backgroundImageWidth = '210mm';
                $backgroundImageHeight = '297mm';
                break;
        }
    @endphp
    <div id="canvas">
        @if(!empty($eventFontImages['backgroundImage']))
            <img src="{{ $eventFontImages['backgroundImage'] }}" alt="Background image" style="position: absolute; width: {{ $backgroundImageWidth }}; height: {{ $backgroundImageHeight }};" />
        @endif
        <style>
            p{
                margin: 0%;
            }

            @page{
                margin: 0px;
                width: 100%;
                height: 100%;
            }

            img{
                margin: 0%;
                height: 0%;
            }
        </style>

        @php
            $typeTextFontPathAsset = asset('fonts/' . $eventFontData->certificate_type_text_font . '.ttf');
            $typeTextFontPathStorage = storage_path('app/fonts/third_party_all/' . $eventFontData->certificate_type_text_font . '.ttf');

            $firstTextFontPathAsset = asset('fonts/' . $eventFontData->first_text_font . '.ttf');
            $firstTextFontPathStorage = storage_path('app/fonts/third_party_all/' . $eventFontData->first_text_font . '.ttf');

            $secondTextFontPathAsset = asset('fonts/' . $eventFontData->second_text_font . '.ttf');
            $secondTextFontPathStorage = storage_path('app/fonts/third_party_all/' . $eventFontData->second_text_font . '.ttf');

            $verifierTextFontPathAsset = asset('fonts/' . $eventFontData->verifier_text_font . '.ttf');
            $verifierTextFontPathStorage = storage_path('app/fonts/third_party_all/' . $eventFontData->verifier_text_font . '.ttf');

            $qrCodeTextFontPathAsset = asset('fonts/' . 'bebasneue' . '.ttf');
            $qrCodeTextFontPathStorage = storage_path('app/fonts/third_party_all/' . 'bebasneue' . '.ttf');
        @endphp

        {{-- Some fonts doesn't have the bold variation so just have to deal with it --}}
        <style>
            @font-face {
                font-family: 'detailsTextType';
                src: url({{ $typeTextFontPathAsset }}) format("truetype");
                font-weight: bold;
                font-style: normal;
            }

            @font-face {
                font-family: 'detailsTextFirst';
                src: url({{ $firstTextFontPathAsset }}) format("truetype");
                font-weight: normal;
                font-style: normal;
            }

            @font-face {
                font-family: 'detailsTextSecond';
                src: url({{ $secondTextFontPathAsset }}) format("truetype");
                font-weight: bold;
                font-style: normal;
            }

            @font-face {
                font-family: 'signatureTextFirst';
                src: url({{ $verifierTextFontPathAsset }}) format("truetype");
                font-weight: bold;
                font-style: normal;
            }

            @font-face {
                font-family: 'signatureTextSecond';
                src: url({{ $verifierTextFontPathAsset }}) format("truetype");
                font-weight: normal;
                font-style: normal;
            }

            @font-face {
                font-family: 'qrCodeText';
                src: url({{ $qrCodeTextFontPathAsset }}) format("truetype");
                font-weight: bold;
                font-style: normal;
            }

            .details-text-type{
                margin: 0px;
                font-size: <?= $eventFontData->certificate_type_text_size ?>em;
                font-weight: bold;
                font-style: normal;
                font-family: 'detailsTextType';
                color: <?= $eventFontData->certificate_type_text_color ?>;
            }

            .details-text-first{
                margin: 0px;
                font-size: <?= $eventFontData->first_text_size ?>em;
                font-weight: normal;
                font-style: normal;
                font-family: 'detailsTextFirst';
                color: <?= $eventFontData->first_text_color ?>;
            }

            .details-text-second{
                margin: 0px;
                font-size: <?= $eventFontData->second_text_size ?>em;
                font-weight: bold;
                font-style: normal;
                font-family: 'detailsTextSecond';
                color: <?= $eventFontData->second_text_color ?>;
            }

            .signature-line{
                margin: 0px;
                font-size: 0.8em;
                font-weight: normal;
                font-style: normal;
                font-family: 'signatureTextFirst';
                color: <?= $eventFontData->verifier_text_color ?>;
            }

            .signature-text-first{
                margin: 0px;
                font-size: <?= $eventFontData->verifier_text_size ?>em;
                font-weight: bold;
                font-style: normal;
                font-family: 'signatureTextFirst';
                color: <?= $eventFontData->verifier_text_color ?>;
            }

            .signature-text-second{
                margin: 0px;
                font-size: <?= $eventFontData->verifier_text_size ?>em;
                font-weight: normal;
                font-style: normal;
                font-family: 'signatureTextSecond';
                color: <?= $eventFontData->verifier_text_color ?>;
            }

            .qr-code-text{
                margin: 0px;
                font-size: 1.1em;
                font-weight: bold;
                font-style: normal;
                font-family: 'qrCodeText';
                color: #000;
            }

            p{
                margin: 0px;
            }
        </style>
        @php
            $defaultText = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum blandit eros eu turpis smmper u.'; // 100 chars
            $defaultTextSmall = 'Lorem ipsum dolor sit amet, consectetur adipiscin.'; // 50 chars
        @endphp
        @if(!empty($eventFontImages['logoFirst']))
            @php
                if(!empty($eventLayoutData->logo_first_input_width)){
                    $logoFirstWidth = $eventLayoutData->logo_first_input_width;
                }else{
                    $logoFirstWidth = '42mm';
                }

                if(!empty($eventLayoutData->logo_first_input_height)){
                    $logoFirstHeight = $eventLayoutData->logo_first_input_height;
                }else{
                    $logoFirstHeight = '42mm';
                }

                if(!empty($eventLayoutData->logo_first_input_translate)){
                    $logoFirstTranslate = 'transform: ' . $eventLayoutData->logo_first_input_translate . ';';
                }else{
                    $logoFirstTranslate = '';
                }
            @endphp
            <img id="logo-first" class="draggable-resizable-square" src="{{ $eventFontImages['logoFirst'] }}" style="{{ $logoFirstTranslate }} background-repeat: no-repeat; background-size: 100%; height: {{ $logoFirstWidth }}; width: {{ $logoFirstHeight }}; position: absolute; top: 0.5%; left: 10%; z-index: 20;" />
        @endif
        @if(!empty($eventFontImages['logoSecond']))
            @php
                if(!empty($eventLayoutData->logo_second_input_width)){
                    $logoSecondWidth = $eventLayoutData->logo_second_input_width;
                }else{
                    $logoSecondWidth = '42mm';
                }

                if(!empty($eventLayoutData->logo_second_input_height)){
                    $logoSecondHeight = $eventLayoutData->logo_second_input_height;
                }else{
                    $logoSecondHeight = '42mm';
                }

                if(!empty($eventLayoutData->logo_second_input_translate)){
                    $logoSecondTranslate = 'transform: ' . $eventLayoutData->logo_second_input_translate . ';';
                }else{
                    $logoSecondTranslate = '';
                }
            @endphp
            <img id="logo-second" class="draggable-resizable-square" src="{{ $eventFontImages['logoSecond'] }}" style="{{ $logoSecondTranslate }} background-repeat: no-repeat; background-size: 100%; height: {{ $logoSecondWidth }}; width: {{ $logoSecondHeight }}; position: absolute; top: 0.5%; left: 40%; z-index: 20;" />
        @endif
        @if(!empty($eventFontImages['logoThird']))
            @php
                if(!empty($eventLayoutData->logo_third_input_width)){
                    $logoThirdWidth = $eventLayoutData->logo_third_input_width;
                }else{
                    $logoThirdWidth = '42mm';
                }

                if(!empty($eventLayoutData->logo_third_input_height)){
                    $logoThirdHeight = $eventLayoutData->logo_third_input_height;
                }else{
                    $logoThirdHeight = '42mm';
                }

                if(!empty($eventLayoutData->logo_third_input_translate)){
                    $logoThirdTranslate = 'transform: ' . $eventLayoutData->logo_third_input_translate . ';';
                }else{
                    $logoThirdTranslate = '';
                }
            @endphp
            <img id="logo-third" class="draggable-resizable-square" src="{{ $eventFontImages['logoThird'] }}" style="{{ $logoThirdTranslate }} background-repeat: no-repeat; background-size: 100%; height: {{ $logoThirdWidth }}; width: {{ $logoThirdHeight }}; position: absolute; top: 0.5%; left: 70%; z-index: 20;" />
        @endif
        @php
            if(!empty($eventLayoutData->details_input_width)){
                $detailsWidth = $eventLayoutData->details_input_width;
            }else{
                $detailsWidth = '210mm';
            }

            if(!empty($eventLayoutData->details_input_height)){
                $detailsHeight = $eventLayoutData->details_input_height;
            }else{
                $detailsHeight = 'auto';
            }

            if(!empty($eventLayoutData->details_input_translate)){
                $detailsTranslate = 'transform: ' . $eventLayoutData->details_input_translate . ';';
            }else{
                $detailsTranslate = '';
            }
        @endphp
        <div id="details" class="draggable-resizable-square" style="{{ $detailsTranslate }} position: absolute; top: 17%; height: {{ $detailsHeight }}; width: {{ $detailsWidth }}; text-align: center; z-index: 10;">
            <div id="details-type" style="margin-bottom: 0.8mm;">
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
                <p class="details-text-type">{{ strtoupper($certificateTitle) }}</p>
            </div>
            <div id="details-intro" style="margin-bottom: 0.8mm;">
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
            <div id="details-participant-details" style="margin-bottom: 0.8mm;">
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
                <p class="details-text-second">{{ strtoupper($certificateFullname) }}</p>
                <p class="details-text-second">({{ $certificateIdentificationNumber }})</p>
            </div>
            <div id="details-position" style="margin-bottom: 0.8mm;">
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
                @if(!empty($certificateData->type))
                    @if($certificateData->type !== 'participation')
                        <p class="details-text-second">{{ strtoupper($certificatePosition) }}</p>
                    @endif
                @endif
            </div>
            <div id="details-event-name" style="margin-bottom: 0.8mm;">
                @if(!empty($certificateData->type))
                    @if($certificateData->type !== 'participation')
                        <p class="details-text-first">Dalam</p>
                    @endif
                @endif
                <p class="details-text-second">{{ strtoupper($eventData->name) }}</p>
            </div>
            @if(!empty($certificateData->category))
                <div id="details-category" style="margin-bottom: 0.8mm;">
                    <p class="details-text-first">Kategori</p>
                    <p class="details-text-second">{{ strtoupper($certificateData->category) }}</p>
                </div>
            @else
                <div id="details-category" style="margin-bottom: 0.8mm;">
                    <p class="details-text-first">Kategori</p>
                    <p class="details-text-second">{{ strtoupper($defaultText) }}</p>
                </div>
            @endif
            <div id="details-date" style="margin-bottom: 0.8mm;">
                <p class="details-text-first">Pada</p>
                <p class="details-text-second">{{ Carbon\Carbon::parse($eventData->date)->format('d/m/Y') }}</p>
            </div>
            <div id="details-event-location" style="margin-bottom: 0.8mm;">
                <p class="details-text-first">Bertempat di</p>
                <p class="details-text-second">{{ strtoupper($eventData->location) }}</p>
            </div>
            <div id="details-event-organiser" style="margin-bottom: 0.8mm;">
                <p class="details-text-first">Anjuran</p>
                <p class="details-text-second">{{ strtoupper($eventData->organiser_name) }}</p>
            </div>
        </div>
        @if(!empty($eventFontImages['signatureFirst']))
            @php
                if(!empty($eventLayoutData->signature_first_input_width)){
                    $signatureFirstWidth = $eventLayoutData->signature_first_input_width;
                }else{
                    $signatureFirstWidth = '67mm';
                }

                if(!empty($eventLayoutData->signature_first_input_height)){
                    $signatureFirstHeight = $eventLayoutData->signature_first_input_height;
                }else{
                    $signatureFirstHeight = 'auto';
                }

                if(!empty($eventLayoutData->signature_first_input_translate)){
                    $signatureFirstTranslate = 'transform: ' . $eventLayoutData->signature_first_input_translate . ';';
                }else{
                    $signatureFirstTranslate = '';
                }
            @endphp
            <div id="signature-first" class="draggable-resizable-rectangle" style="{{ $signatureFirstTranslate }} width: {{ $signatureFirstWidth }}; height: {{ $signatureFirstHeight }}; top: 76%; left: 5%; position: absolute; text-align: center; z-index: 10;">
                <img id="signature-first-image" src="{{ $eventFontImages['signatureFirst'] }}" style="width: 13.5em; height: 4.5em;" />
                <div style="line-height: 0;">
                    <p class="signature-line">...............................................................</p>
                </div>
                <div id="signature-first-name" style="margin-bottom: 0.3em;">
                    <p class="signature-text-first">({{ strtoupper($eventData->signature_first_name) }})</p>
                </div>
                <div id="signature-first-position">
                    <p class="signature-text-second">{{ strtoupper($eventData->signature_first_position) }}</p>
                </div>
            </div>
        @endif
        @if(!empty($eventFontImages['signatureSecond']))
            @php
                if(!empty($eventLayoutData->signature_second_input_width)){
                    $signatureSecondWidth = $eventLayoutData->signature_second_input_width;
                }else{
                    $signatureSecondWidth = '67mm';
                }

                if(!empty($eventLayoutData->signature_second_input_height)){
                    $signatureSecondHeight = $eventLayoutData->signature_second_input_height;
                }else{
                    $signatureSecondHeight = 'auto';
                }

                if(!empty($eventLayoutData->signature_second_input_translate)){
                    $signatureSecondTranslate = 'transform: ' . $eventLayoutData->signature_second_input_translate . ';';
                }else{
                    $signatureSecondTranslate = '';
                }
            @endphp
            <div id="signature-second" class="draggable-resizable-rectangle" style="{{ $signatureSecondTranslate }} width: {{ $signatureSecondWidth }}; height: {{ $signatureSecondHeight }}; top: 76%; left: 35%; position: absolute; text-align: center; z-index: 10;">
                <img id="signature-second-image" src="{{ $eventFontImages['signatureSecond'] }}" style="width: 13.5em; height: 4.5em" />
                <div style="line-height: 0;">
                    <p class="signature-line">...............................................................</p>
                </div>
                <div id="signature-second-name" style="margin-bottom: 0.3em;">
                    <p class="signature-text-first">({{ strtoupper($eventData->signature_second_name) }})</p>
                </div>
                <div id="signature-second-position">
                    <p class="signature-text-second">{{ strtoupper($eventData->signature_second_position) }}</p>
                </div>
            </div>
        @endif
        @if(!empty($eventFontImages['signatureThird']))
            @php
                if(!empty($eventLayoutData->signature_third_input_width)){
                    $signatureThirdWidth = $eventLayoutData->signature_third_input_width;
                }else{
                    $signatureThirdWidth = '67mm';
                }

                if(!empty($eventLayoutData->signature_third_input_height)){
                    $signatureThirdHeight = $eventLayoutData->signature_third_input_height;
                }else{
                    $signatureThirdHeight = 'auto';
                }

                if(!empty($eventLayoutData->signature_third_input_translate)){
                    $signatureThirdTranslate = 'transform: ' . $eventLayoutData->signature_third_input_translate . ';';
                }else{
                    $signatureThirdTranslate = '';
                }
            @endphp
            <div id="signature-third" class="draggable-resizable-rectangle" style="{{ $signatureThirdTranslate }} width: {{ $signatureThirdWidth }}; height: {{ $signatureThirdHeight }}; top: 76%; left: 65%; position: absolute; text-align: center; z-index: 10;">
                <img id="signature-third-image" src="{{ $eventFontImages['signatureThird'] }}" style="width: 13.5em; height: 4.5em" />
                <div style="line-height: 0;">
                    <p class="signature-line">...............................................................</p>
                </div>
                <div id="signature-third-name" style="margin-bottom: 0.3em;">
                    <p class="signature-text-first">({{ strtoupper($eventData->signature_third_name) }})</p>
                </div>
                <div id="signature-third-position">
                    <p class="signature-text-second">{{ strtoupper($eventData->signature_third_position) }}</p>
                </div>
            </div>
        @endif
        @if(!empty($eventData->visibility))
            @if($eventData->visibility == 'public')
                @php
                    if(!empty($eventLayoutData->qr_code_input_translate)){
                        $qrCodeTranslate = 'transform: ' . $eventLayoutData->qr_code_input_translate . ';';
                    }else{
                        $qrCodeTranslate = '';
                    }
                @endphp
                <div id="qr-code" class="draggable-rectangle" style="{{ $qrCodeTranslate }} margin-bottom: 10mm; height: 21mm; width: 75mm; position: absolute; top: 92%; left: 62%; border: 0.7mm solid black; z-index: 10; background: #fff;">
                    <div style="margin-left: 0.5mm; width: 70%;">
                        <div style="width: 100%;">
                            @php
                                if(!empty($certificateData->uid)){
                                    $certificateID = $certificateData->uid;
                                }else{
                                    $certificateID = 'AAAAAAA00000000';
                                }
                            @endphp
                            <p class="qr-code-text">Imbas Kod QR Ini Untuk Memeriksa Ketulenan</p>
                            <p class="qr-code-text">ID Sijil: {{ $certificateID }}</p>
                        </div>
                    </div>
                    @if(!empty($qrCodeDataURI))
                        <img id="qr-code-image" style="background: #000; background-repeat: no-repeat; background-size: 100%; width: 20mm; height: 20mm; position: absolute; top: 3%; left: 72%;" src="{{ $qrCodeDataURI }}" />
                    @endif
                </div>
            @endif
        @endif
    </div>
</body>
</html>
