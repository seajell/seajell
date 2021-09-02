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
    <div id="canvas" style="position: relative;">
        @if(!empty($eventData->background_image))
            <img src="{{ storage_path('app/public' . $eventData->background_image) }}" alt="Background image" style="position: absolute; width: 100%; height: auto;">
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
        {{-- Importing fonts --}}
        {{-- $fontSetOne = ['cookie', 'badscript', 'bebasneue', 'bebasneue', 'poppins'];
        $fontSetTwo = ['lobster', 'poiretone', 'poppins', 'bebasneue', 'poppins'];
        $fontSetThree = ['oleoscript', 'architectsdaughter', 'righteous', 'bebasneue', 'poppins'];
        $fontSetFour = ['berkshireswash', 'satisfy', 'fredokaone', 'bebasneue', 'poppins'];
        $fontSetFive = ['kaushanscript', 'rancho', 'carterone', 'bebasneue', 'poppins']; --}}
        {{-- // Font 1: Certificate type
        // Font 2: Odd
        // Font 3: Even
        // Font 4: Verifier name
        // Font 5: Verifier position --}}
        @php
            /**
             * Index 0: Certificate type
             * Index 1: Details text first
             * Index 2: Details text second
             * Index 3: Signature text first
             * Index 4: Signature text second
             * Font sizes are in em unit.
             */
            $fontSetOne = ['cookie', 'badscript', 'bebasneue', 'bebasneue', 'Poppins-Regular'];
            $fontSetSizeOne = [2.3, 1.1, 1.2, 1.1, 0.9];

            $fontSetTwo = ['Lobster-Regular', 'PoiretOne-Regular', 'Poppins-Regular', 'bebasneue', 'Poppins-Regular'];
            $fontSetSizeTwo = [2.3, 1.3, 1, 1.1, 0.9];

            $fontSetThree = ['OleoScript-Bold', 'ArchitectsDaughter-Regular', 'Righteous-Regular', 'bebasneue', 'Poppins-Regular'];
            $fontSetSizeThree = [2.3, 1.3, 1, 1.1, 0.9];

            $fontSetFour = ['BerkshireSwash-Regular', 'Satisfy-Regular', 'FredokaOne-Regular', 'bebasneue', 'Poppins-Regular'];
            $fontSetSizeFour = [2.3, 1.3, 1, 1.1, 0.9];

            $fontSetFive = ['KaushanScript-Regular', 'Rancho-Regular', 'CarterOne-Regular', 'bebasneue', 'Poppins-Regular'];
            $fontSetSizeFive = [2.3, 1.3, 1, 1.1, 0.9];

            switch ($eventData->font_set) {
                case 1:
                    $fontSetSelected = $fontSetOne;
                    $fontSetSizeSelected = $fontSetSizeOne;
                    break;
                case 2:
                    $fontSetSelected = $fontSetTwo;
                    $fontSetSizeSelected = $fontSetSizeTwo;
                    break;
                case 3:
                    $fontSetSelected = $fontSetThree;
                    $fontSetSizeSelected = $fontSetSizeThree;
                    break;
                case 4:
                    $fontSetSelected = $fontSetFour;
                    $fontSetSizeSelected = $fontSetSizeFour;
                    break;
                case 5:
                    $fontSetSelected = $fontSetFive;
                    $fontSetSizeSelected = $fontSetSizeFive;
                    break;
                default:
                    $fontSetSelected = $fontSetFive;
                    $fontSetSizeSelected = $fontSetSizeFive;
                    break;
            }
        @endphp
        <style>
            /* Try and load fonts with storage_path */

            @font-face {
                font-family: 'detailsTextType';
                src: url({{ storage_path('app/fonts/third_party_all/' . $fontSetSelected[0] . '.ttf') }}) format("truetype");
                font-weight: normal;
                font-style: normal;
            }

            @font-face {
                font-family: 'detailsTextFirst';
                src: url({{ storage_path('app/fonts/third_party_all/' . $fontSetSelected[1] . '.ttf') }}) format("truetype");
                font-weight: normal;
                font-style: normal;
            }

            @font-face {
                font-family: 'detailsTextSecond';
                src: url({{ storage_path('app/fonts/third_party_all/' . $fontSetSelected[2] . '.ttf') }}) format("truetype");
                font-weight: bold;
                font-style: normal;
            }

            @font-face {
                font-family: 'signatureTextFirst';
                src: url({{ storage_path('app/fonts/third_party_all/' . $fontSetSelected[3] . '.ttf') }}) format("truetype");
                font-weight: normal;
                font-style: normal;
            }

            @font-face {
                font-family: 'signatureTextSecond';
                src: url({{ storage_path('app/fonts/third_party_all/' . $fontSetSelected[4] . '.ttf') }}) format("truetype");
                font-weight: normal;
                font-style: normal;
            }

            @font-face {
                font-family: 'qrCodeText';
                src: url({{ storage_path('app/fonts/third_party_all/bebasneue.ttf') }}) format("truetype");
                font-weight: bold;
                font-style: normal;
            }

            .details-text-type{
                margin: 0px;
                font-size: <?= $fontSetSizeSelected[0] ?>em; 
                font-weight: normal;
                font-style: normal;
                font-family: 'detailsTextType';
                color: <?= $eventData->text_color ?>;
            }

            .details-text-first{
                margin: 0px;
                font-size: <?= $fontSetSizeSelected[1] ?>em;
                font-weight: normal;
                font-style: normal;
                font-family: 'detailsTextFirst';
                color: <?= $eventData->text_color ?>;
            }

            .details-text-second{
                margin: 0px;
                font-size: <?= $fontSetSizeSelected[2] ?>em;
                font-weight: bold;
                font-style: normal;
                font-family: 'detailsTextSecond';
                color: <?= $eventData->text_color ?>;
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
                font-size: <?= $fontSetSizeSelected[3] ?>em;
                font-weight: normal;
                font-style: normal;
                font-family: 'signatureTextFirst';
                color: <?= $eventData->text_color ?>;
            }

            .signature-text-second{
                margin: 0px;
                font-size: <?= $fontSetSizeSelected[4] ?>em;
                font-weight: normal;
                font-style: normal;
                font-family: 'signatureTextSecond';
                color: <?= $eventData->text_color ?>;
            }

            .qr-code-text{
                margin: 0px;
                font-size: 1.2em;
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
            <div id="logo-first" style="background: url({{ storage_path('app/public' . $eventData->logo_first) }}); background-repeat: no-repeat; background-size: 100%; height: 42mm; width: 42mm; transform: translate(-50%, 0);  position: absolute; top: 0.5%; left: 20%; z-index: 10;"></div>
        @endif
        @if(!empty($eventData->logo_second))
            <div id="logo-second" style="background: url({{ storage_path('app/public' . $eventData->logo_second) }}); background-repeat: no-repeat; background-size: 100%; height: 42mm; width: 42mm; transform: translate(-50%, 0);  position: absolute; top: 0.5%; left: 50%; z-index: 10;"></div>
        @endif
        @if(!empty($eventData->logo_third))
            <div id="logo-third" style="background: url({{ storage_path('app/public' . $eventData->logo_third) }}); background-repeat: no-repeat; background-size: 100%; height: 42mm; width: 42mm; transform: translate(-50%, 0);  position: absolute; top: 0.5%; left: 80%; z-index: 10;"></div>
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
                <div id="signature-first-image" style="background: url({{ storage_path('app/public' . $eventData->signature_first) }}); background-repeat: no-repeat; background-size: 100%; width: 13.5em; height: 4.5em; transform: translate(-50%, 0); position: relative; left: 50%;"></div>
                <div>
                    <p class="signature-line">...............................................................</p>
                </div>
                <div id="signature-first-name" style="margin-bottom: 0.3mm;">
                    <p class="signature-text-first">{{ strtoupper($eventData->signature_first_name) }}</p>
                </div>
                <div id="signature-first-position">
                    <p class="signature-text-second">{{ strtoupper($eventData->signature_first_position) }}</p>
                </div>
            </div>
        @endif
        @if(!empty($eventData->signature_second))
            <div id="signature-second" style="width: 67mm; top: 76%; left: 50%; transform: translate(-50%, 0);  position: absolute; text-align: center; z-index: 10;">
                <div id="signature-second-image" style="background: url({{ storage_path('app/public' . $eventData->signature_second) }}); background-repeat: no-repeat; background-size: 100%; width: 13.5em; height: 4.5em; transform: translate(-50%, 0); position: relative; left: 50%;"></div>
                <div>
                    <p class="signature-line">...............................................................</p>
                </div>
                <div id="signature-second-name" style="margin-bottom: 0.3mm;">
                    <p class="signature-text-first">{{ strtoupper($eventData->signature_second_name) }}</p>
                </div>
                <div id="signature-second-position">
                    <p class="signature-text-second">{{ strtoupper($eventData->signature_second_position) }}</p>
                </div>
            </div>
        @endif
        @if(!empty($eventData->signature_third))
            <div id="signature-third" style="width: 67mm; top: 76%; left: 82%; transform: translate(-50%, 0);  position: absolute; text-align: center; z-index: 10;">
                <div id="signature-third-image" style="background: url({{ storage_path('app/public' . $eventData->signature_third) }}); background-repeat: no-repeat; background-size: 100%; width: 13.5em; height: 4.5em; transform: translate(-50%, 0); position: relative; left: 50%;"></div>
                <div>
                    <p class="signature-line">...............................................................</p>
                </div>
                <div id="signature-third-name" style="margin-bottom: 0.3mm;">
                    <p class="signature-text-first">{{ strtoupper($eventData->signature_third_name) }}</p>
                </div>
                <div id="signature-third-position">
                    <p class="signature-text-second">{{ strtoupper($eventData->signature_third_position) }}</p>
                </div>
            </div>
        @endif
        @if(!empty($eventData->visibility))
            @if($eventData->visibility == 'public')
                <div id="qr-code" style="margin-bottom: 10mm; height: 25mm; width: 75mm; position: absolute; top: 93%; left: 79%; transform: translate(-50%, 0); border: 1mm solid black; z-index: 10; background: #fff;">
                    <div style="margin: 0.5mm; width: 65%; height: 96%;">
                        <div style="width: 100%; height: 100%; margin: 0.5mm;">
                            @php
                                if(!empty($certificateData->uid)){
                                    $certificateID = $certificateData->uid;
                                }else{
                                    $certificateID = 'AAAA0000';
                                }
                            @endphp
                            <p class="qr-code-text">Imbas Kod QR Ini Untuk Menyemak Ketulenan</p>
                            <p style="margin-top: 0.5mm;" class="qr-code-text">ID Sijil: {{ $certificateID }}</p>
                        </div>
                    </div>
                    <div id="qr-code-image" style="background: #000; background-repeat: no-repeat; background-size: 100%; width: 23mm; height: 23mm; position: absolute; top: 3%; left: 67%;"></div>
                </div>
            @endif
        @endif
    </div>
</body>
</html>