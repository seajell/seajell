const { isEmpty } = require("lodash");

document.addEventListener("DOMContentLoaded", function (event) {
    // Disable the inputs unless they click the checks.
    
    // Logo
    var logoSecondCheck = document.querySelector('#logo-second-check');
    var logoSecond = document.querySelector('#logo-second');
    logoSecond.disabled = true;
    logoSecondCheck.addEventListener('change', function (event) {
        if (logoSecondCheck.checked) {
            logoSecond.disabled = false;
        } else {
            logoSecond.disabled = true;
        }
    });

    var logoThirdCheck = document.querySelector('#logo-third-check');
    var logoThird = document.querySelector('#logo-third');
    logoThird.disabled = true;
    logoThirdCheck.addEventListener('change', function (event) {
        if (logoThirdCheck.checked) {
            logoThird.disabled = false;
        } else {
            logoThird.disabled = true;
        }
    });

    // Signature
    var signatureSecondCheck = document.querySelector('#signature-second-check');
    var signatureSecondName = document.querySelector('#signature-second-name');
    var signatureSecondPosition = document.querySelector('#signature-second-position');
    var signatureSecond = document.querySelector('#signature-second');
    if(isEmpty(signatureSecondName.value)){
        signatureSecondName.disabled = true;
        signatureSecondPosition.disabled = true;
        signatureSecond.disabled = true;
    }
    signatureSecondCheck.addEventListener('change', function (event) {
        if (signatureSecondCheck.checked) {
            signatureSecondName.disabled = false;
            signatureSecondPosition.disabled = false;
            signatureSecond.disabled = false;
        } else {
            signatureSecondName.disabled = true;
            signatureSecondPosition.disabled = true;
            signatureSecond.disabled = true;
        }
    });

    var signatureThirdCheck = document.querySelector('#signature-third-check');
    var signatureThirdName = document.querySelector('#signature-third-name');
    var signatureThirdPosition = document.querySelector('#signature-third-position');
    var signatureThird = document.querySelector('#signature-third');
    if(isEmpty(signatureThirdName.value)){
        signatureThirdName.disabled = true;
        signatureThirdPosition.disabled = true;
        signatureThird.disabled = true;
    }
    signatureThirdCheck.addEventListener('change', function (event) {
        if (signatureThirdCheck.checked) {
            signatureThirdName.disabled = false;
            signatureThirdPosition.disabled = false;
            signatureThird.disabled = false;
        } else {
            signatureThirdName.disabled = true;
            signatureThirdPosition.disabled = true;
            signatureThird.disabled = true;
        }
    });
});