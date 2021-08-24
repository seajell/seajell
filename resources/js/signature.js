// Copyright (c) 2021 Muhammad Hanis Irfan bin Mohd Zaid

// This file is part of SeaJell.

// SeaJell is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

// SeaJell is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.

// You should have received a copy of the GNU General Public License
// along with SeaJell.  If not, see <https://www.gnu.org/licenses/>.

import SignaturePad from '../../node_modules/signature_pad/dist/signature_pad';

var canvasWrapper = document.getElementById('signature-pad-wrapper');
var canvas = canvasWrapper.querySelector('#signature-pad');
var saveBtn = document.querySelector('#signature-pad-save');
var undoBtn = document.querySelector('#signature-pad-undo');
var clearBtn = document.querySelector('#signature-pad-clear');

var signaturePad = new SignaturePad(canvas, {
    backgroundColor: 'rgba(255, 255, 255, 0)',
    penColor: 'rgb(0, 0, 0)',
    minWidth: 4,
    maxWidth: 7,
});

/**
 * Some of the code are taken from the Signature Pad demo
 * https://github.com/szimek/signature_pad
 */
 function download(dataURL, filename) {
    var blob = dataURLToBlob(dataURL);
    var url = window.URL.createObjectURL(blob);
  
    var a = document.createElement("a");
    a.style = "display: none";
    a.href = url;
    a.download = filename;
  
    document.body.appendChild(a);
    a.click();
  
    window.URL.revokeObjectURL(url);
}

function dataURLToBlob(dataURL) {
    // Code taken from https://github.com/ebidel/filer.js
    var parts = dataURL.split(';base64,');
    var contentType = parts[0].split(":")[1];
    var raw = window.atob(parts[1]);
    var rawLength = raw.length;
    var uInt8Array = new Uint8Array(rawLength);
  
    for (var i = 0; i < rawLength; ++i) {
      uInt8Array[i] = raw.charCodeAt(i);
    }
  
    return new Blob([uInt8Array], { type: contentType });
}

// Save PNG image
var today = new Date();
var date = today.getFullYear()+'_'+(today.getMonth()+1)+'_'+today.getDate();

saveBtn.addEventListener('click', function (event) {
    if (signaturePad.isEmpty()) {
        alert("Sila tuliskan tandatangan anda dahulu.");
    } else {
        var dataURL = signaturePad.toDataURL();
        download(dataURL, "SeaJell_Tandatangan_" + date + ".png");
    }
});


// Undo move
undoBtn.addEventListener("click", function (event) {
    var data = signaturePad.toData();
  
    if (data) {
      data.pop(); 
      signaturePad.fromData(data);
    }
});
  
// CLear pad
clearBtn.addEventListener('click', function (event) {
    signaturePad.clear();
});

function resizeCanvas() {
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    console.log(canvas.width);
    console.log(canvas.height);
    canvas.style.border = 'solid #000' 
    canvas.getContext("2d").scale(ratio, ratio);
    signaturePad.clear(); // otherwise isEmpty() might return incorrect value
}

window.addEventListener("resize", resizeCanvas);
resizeCanvas();