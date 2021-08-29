<div id="canvas" style="background: #fff; height: 297mm; width: 210mm; position: relative;">
    <style>
        p{
            margin: 0%;
        }

        .details-text-type{
            font-size: 3em; 
            font-weight: bold;
        }

        .details-text-first{
            font-size: 1em;
        }

        .details-text-second{
            font-size: 1.1em;
        }

        .signature-text{
            font-size: 0.9em;
        }

        #qr-code-text{
            font-size: 1em;
        }
        @page{ 
            margin: 0px; 
        }
    </style>
    @php
        $defaultText = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum blandit eros eu turpis semper u.';
    @endphp
    <div id="logo-first" style="background: #000; background-repeat: no-repeat; background-size: 100%; height: 10em; width: 10em; transform: translate(-50%, 0);  position: absolute; top: 0.5%; left: 20%; z-index: 10;"></div>
    <div id="logo-second" style="background: #000; background-repeat: no-repeat; background-size: 100%; height: 10em; width: 10em; transform: translate(-50%, 0);  position: absolute; top: 0.5%; left: 50%; z-index: 10;"></div>
    <div id="logo-third" style="background: #000; background-repeat: no-repeat; background-size: 100%; height: 10em; width: 10em; transform: translate(-50%, 0);  position: absolute; top: 0.5%; left: 80%; z-index: 10;"></div>
    <div id="details" style="height: 44em; width: 49em; transform: translate(-50%, 0); position: absolute; top: 15%; left: 50%; text-align: center; z-index: 10; background: orange;">
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
    <div id="signature-first" class="signature-text" style="width: 19em; top: 68%; left: 20%; transform: translate(-50%, 0);  position: absolute; text-align: center; z-index: 10;">
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
    <div id="signature-second" class="signature-text" style="width: 19em; top: 68%; left: 50%; transform: translate(-50%, 0);  position: absolute; text-align: center; z-index: 10;">
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
    <div id="signature-third" class="signature-text" style="width: 19em; top: 68%; left: 80%; transform: translate(-50%, 0);  position: absolute; text-align: center; z-index: 10;">
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
    <div id="qr-code" style="height: 6.5em; width: 21.5em; top: 90%; left: 75%; transform: translate(-50%, 0);  position: absolute; border: 0.3em solid black; z-index: 10;">
        <div id="qr-code-text" style="width: 15em; height: 6em;">
            <p style="margin-left: 0.5em; margin-bottom: 0.7em; width: 95%;">Imbas Kod QR Ini Untuk Menyemak Ketulenan</p>
            <p style="margin-left: 0.5em; width: 95%;">ID Sijil: AAAA0000</p>
        </div>
        <div id="qr-code-image" style="background: #000; background-repeat: no-repeat; background-size: 100%; width: 5.8em; height: 5.8em; position: absolute; top: 1%; left: 72%;"></div>
    </div>
    <div style="height: 297mm; width: 105mm; top: 0%; left: 0%; position: absolute; background: red; z-index: 1;"></div>
    <div style="height: 297mm; width: 105mm; top: 0%; left: 50%; position: absolute; background: blue; z-index: 1;"></div>
</div>