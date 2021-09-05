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
    <title>SeaJell - Certificate View</title>
</head>
<body>
    {{-- Don't forget to remove the height and width of the #canvas element in order to remove overflow --}}
    <div id="canvas" style="position: relative;" class="my-5">
        @if(!empty($eventData->background_image))
            @php
                $backgroundImagePathAsset = asset('storage' . $eventData->background_image);
                $backgroundImagePathStorage = storage_path('app/public' . $eventData->background_image);
            @endphp
            <img src="{{ $backgroundImagePathStorage }}" alt="Background image" style="position: absolute; width: 100%; height: auto;">
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

            $qrCodeTextFontPathAsset = asset('fonts/' . 'poppins' . '.ttf');
            $qrCodeTextFontPathStorage = storage_path('app/fonts/third_party_all/' . 'poppins' . '.ttf');
        @endphp
        
        <style>
            @font-face {
                font-family: 'detailsTextType';
                src: url({{ $typeTextFontPathStorage }}) format("truetype");
                font-weight: bold;
                font-style: normal;
            }

            @font-face {
                font-family: 'detailsTextFirst';
                src: url({{ $firstTextFontPathStorage }}) format("truetype");
                font-weight: normal;
                font-style: normal;
            }

            @font-face {
                font-family: 'detailsTextSecond';
                src: url({{ $secondTextFontPathStorage }}) format("truetype");
                font-weight: bold;
                font-style: normal;
            }

            @font-face {
                font-family: 'signatureTextFirst';
                src: url({{ $verifierTextFontPathStorage }}) format("truetype");
                font-weight: bold;
                font-style: normal;
            }

            @font-face {
                font-family: 'signatureTextSecond';
                src: url({{ $verifierTextFontPathStorage }}) format("truetype");
                font-weight: normal;
                font-style: normal;
            }

            @font-face {
                font-family: 'qrCodeText';
                src: url({{ $qrCodeTextFontPathStorage }}) format("truetype");
                font-weight: normal;
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
                color: <?= $eventData->text_color ?>;
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
                font-size: 1em;
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
        @if(!empty($eventData->logo_first))
            @php
                $logoFirstPathAsset = asset('storage' . $eventData->logo_first);
                $logoFirstPathStorage = storage_path('app/public' . $eventData->logo_first);
            @endphp
            <div id="logo-first" style="background: url({{ $logoFirstPathStorage }}); background-repeat: no-repeat; background-size: 100%; height: 42mm; width: 42mm; transform: translate(-50%, 0);  position: absolute; top: 0.5%; left: 20%; z-index: 10;"></div>
        @endif
        @if(!empty($eventData->logo_second))
            @php
                $logoSecondPathAsset = asset('storage' . $eventData->logo_second);
                $logoSecondPathStorage = storage_path('app/public' . $eventData->logo_second);
            @endphp
            <div id="logo-second" style="background: url({{ $logoSecondPathStorage }}); background-repeat: no-repeat; background-size: 100%; height: 42mm; width: 42mm; transform: translate(-50%, 0);  position: absolute; top: 0.5%; left: 50%; z-index: 10;"></div>
        @endif
        @if(!empty($eventData->logo_third))
            @php
                $logoThirdPathAsset = asset('storage' . $eventData->logo_third);
                $logoThirdPathStorage = storage_path('app/public' . $eventData->logo_third);
            @endphp
            <div id="logo-third" style="background: url({{ $logoThirdPathStorage }}); background-repeat: no-repeat; background-size: 100%; height: 42mm; width: 42mm; transform: translate(-50%, 0);  position: absolute; top: 0.5%; left: 80%; z-index: 10;"></div>
        @endif
        <div id="details" style="height: 170mm; width: 200mm; transform: translate(-50%, 0); position: absolute; top: 15%; left: 50%; text-align: center; z-index: 10;">
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
                <p class="details-text-type">{{ strtoupper($certificateTitle) }}</p>
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
                <p class="details-text-second">{{ strtoupper($certificateFullname) }}</p>
                <p class="details-text-second">({{ $certificateIdentificationNumber }})</p>
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
                <p class="details-text-second">{{ strtoupper($certificatePosition) }}</p>
            </div>
            <div id="details-event-name" style="margin-bottom: 1mm;">
                <p class="details-text-first">Dalam</p>
                <p class="details-text-second">{{ strtoupper($eventData->name) }}</p>
            </div>
            @if(!empty($certificateData->category))
                <div id="details-category" style="margin-bottom: 1mm;">
                    <p class="details-text-first">Kategori</p>
                    <p class="details-text-second">{{ strtoupper($certificateData->category) }}</p>
                </div>
            @else
                <div id="details-category" style="margin-bottom: 1mm;">
                    <p class="details-text-first">Kategori</p>
                    <p class="details-text-second">{{ strtoupper($defaultText) }}</p>
                </div>
            @endif
            <div id="details-date" style="margin-bottom: 1mm;">
                <p class="details-text-first">Pada</p>
                <p class="details-text-second">{{ Carbon\Carbon::parse($eventData->date)->format('d/m/Y') }}</p>
            </div>
            <div id="details-event-location" style="margin-bottom: 1mm;">
                <p class="details-text-first">Bertempat di</p>
                <p class="details-text-second">{{ strtoupper($eventData->location) }}</p>
            </div>
            <div id="details-event-organiser" style="margin-bottom: 1mm;">
                <p class="details-text-first">Anjuran</p>
                <p class="details-text-second">{{ strtoupper($eventData->organiser_name) }}</p>
            </div>
        </div>
        @if(!empty($eventData->signature_first))
        {{-- url({{ storage_path('app/public' . $eventData->signature_first) }}) --}}
            <div id="signature-first" style="width: 67mm; top: 76%; left: 18%; transform: translate(-50%, 0);  position: absolute; text-align: center; z-index: 10;">
                @php
                    $signatureFirstPathAsset = asset('storage' . $eventData->signature_first);
                    $signatureFirstPathStorage = storage_path('app/public' . $eventData->signature_first);
                @endphp
                <div id="signature-first-image" style="background: url({{ $signatureFirstPathStorage }}); background-repeat: no-repeat; background-size: 100%; width: 13.5em; height: 4.5em; transform: translate(-50%, 0); position: relative; left: 50%;"></div>
                <div>
                    <p class="signature-line">...............................................................</p>
                </div>
                <div id="signature-first-name" style="margin-bottom: 0.3mm;">
                    <p class="signature-text-first">({{ strtoupper($eventData->signature_first_name) }})</p>
                </div>
                <div id="signature-first-position">
                    <p class="signature-text-second">{{ strtoupper($eventData->signature_first_position) }}</p>
                </div>
            </div>
        @endif
        @if(!empty($eventData->signature_second))
            <div id="signature-second" style="width: 67mm; top: 76%; left: 50%; transform: translate(-50%, 0);  position: absolute; text-align: center; z-index: 10;">
                @php
                    $signatureSecondPathAsset = asset('storage' . $eventData->signature_second);
                    $signatureSecondPathStorage = storage_path('app/public' . $eventData->signature_second);
                @endphp
                <div id="signature-second-image" style="background: url({{ $signatureSecondPathStorage }}); background-repeat: no-repeat; background-size: 100%; width: 13.5em; height: 4.5em; transform: translate(-50%, 0); position: relative; left: 50%;"></div>
                <div>
                    <p class="signature-line">...............................................................</p>
                </div>
                <div id="signature-second-name" style="margin-bottom: 0.3mm;">
                    <p class="signature-text-first">({{ strtoupper($eventData->signature_second_name) }})</p>
                </div>
                <div id="signature-second-position">
                    <p class="signature-text-second">{{ strtoupper($eventData->signature_second_position) }}</p>
                </div>
            </div>
        @endif
        @if(!empty($eventData->signature_third))
            <div id="signature-third" style="width: 67mm; top: 76%; left: 82%; transform: translate(-50%, 0);  position: absolute; text-align: center; z-index: 10;">
                @php
                    $signatureThirdPathAsset = asset('storage' . $eventData->signature_third);
                    $signatureThirdPathStorage = storage_path('app/public' . $eventData->signature_third);
                @endphp
                <div id="signature-third-image" style="background: url({{ $signatureThirdPathStorage }}); background-repeat: no-repeat; background-size: 100%; width: 13.5em; height: 4.5em; transform: translate(-50%, 0); position: relative; left: 50%;"></div>
                <div>
                    <p class="signature-line">...............................................................</p>
                </div>
                <div id="signature-third-name" style="margin-bottom: 0.3mm;">
                    <p class="signature-text-first">({{ strtoupper($eventData->signature_third_name) }})</p>
                </div>
                <div id="signature-third-position">
                    <p class="signature-text-second">{{ strtoupper($eventData->signature_third_position) }}</p>
                </div>
            </div>
        @endif
        @if(!empty($eventData->visibility))
            @if($eventData->visibility == 'public')
                <div id="qr-code" style="margin-bottom: 10mm; height: 21mm; width: 80mm; position: absolute; top: 95%; left: 79%; transform: translate(-50%, 0); border: 1mm solid black; z-index: 10; background: #fff;">
                    <div style="margin: 0.5mm; width: 80%; height: 96%;">
                        <div style="width: 100%; height: 100%; margin: 0.5mm;">
                            @php
                                if(!empty($certificateData->uid)){
                                    $certificateID = $certificateData->uid;
                                }else{
                                    $certificateID = 'AAAAAAA00000000';
                                }
                            @endphp
                            <p class="qr-code-text">Scan This QR Code To Check Authenticity</p>
                            <p style="margin-top: 0.5mm;" class="qr-code-text">Certificate ID: {{ $certificateID }}</p>
                        </div>
                    </div>
                    <div id="qr-code-image" style="background: #000; background-repeat: no-repeat; background-size: 100%; width: 20mm; height: 20mm; position: absolute; top: 3%; left: 74%;"></div>
                </div>
            @endif
        @endif
    </div>
</body>
</html>