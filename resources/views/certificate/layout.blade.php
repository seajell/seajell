<div id="canvas" style="background: #fff; height: 297mm; width: 210mm; position: relative;">
    <style>
        p{
            margin: 0%;
        }

        .details-text-type{
            font-size: 12mm; 
            font-weight: bold;
        }

        .details-text-first{
            font-size: 4mm;
        }

        .details-text-second{
            font-size: 5mm;
        }

        .signature-text{
            font-size: 4mm;
        }

        #qr-code-text{
            font-size: 4mm;
        }
        @page{ 
            margin: 0px; 
        }
    </style>
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