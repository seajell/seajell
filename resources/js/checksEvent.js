const { isEmpty } = require("lodash");

document.addEventListener("DOMContentLoaded", function (event) {
    // Disable the inputs unless they click the checks.
    const logoSecondCheck = document.querySelector('#logo-second-check');
    const logoSecond = document.querySelector('#logo-second');
    const logoThirdCheck = document.querySelector('#logo-third-check');
    const logoThird = document.querySelector('#logo-third');
    const signatureSecondCheck = document.querySelector('#signature-second-check');
    const signatureSecondName = document.querySelector('#signature-second-name');
    const signatureSecondPosition = document.querySelector('#signature-second-position');
    const signatureSecond = document.querySelector('#signature-second');
    const signatureThirdCheck = document.querySelector('#signature-third-check');
    const signatureThirdName = document.querySelector('#signature-third-name');
    const signatureThirdPosition = document.querySelector('#signature-third-position');
    const signatureThird = document.querySelector('#signature-third');
    const backgroundImage = document.querySelector('#background-image');
    const backgroundImageCheck = document.querySelector('#background-image-check');
    const backgroundImageData = document.querySelector('#background-image-data');
    const logoSecondData = document.querySelector('#logo-second-data');
    const logoThirdData = document.querySelector('#logo-third-data');

    // Logo
    if(logoSecondData){
        if(!isEmpty(logoSecondData.value)){
            logoSecondCheck.checked = true;
        }else{
            logoSecond.disabled = true;
        }
    }else{
        logoSecond.disabled = true;
    }

    logoSecondCheck.addEventListener('change', function (event) {
        if (logoSecondCheck.checked) {
            logoSecond.disabled = false;
        } else {
            logoSecond.disabled = true;
        }
    });

    if(logoThirdData){
        if(!isEmpty(logoThirdData.value)){
            logoThirdCheck.checked = true;
        }else{
            logoThird.disabled = true;
        }
    }else{
        logoThird.disabled = true;
    }

    logoThirdCheck.addEventListener('change', function (event) {
        if (logoThirdCheck.checked) {
            logoThird.disabled = false;
        } else {
            logoThird.disabled = true;
        }
    });

    // Signature
    if(!isEmpty(signatureSecondName.value)){
        signatureSecondCheck.checked = true;
    }else{
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

    if(!isEmpty(signatureThirdName.value)){
        signatureThirdCheck.checked = true;
    }else{
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

    // Background Image
    if(backgroundImageData){
        if(!isEmpty(backgroundImageData.value)){
            backgroundImageCheck.checked = true;
        }else{
            backgroundImage.disabled = true;
        }
    }else{
        backgroundImage.disabled = true;
    }

    backgroundImageCheck.addEventListener('change', function (event) {
        if (backgroundImageCheck.checked) {
            backgroundImage.disabled = false;
        } else {
            backgroundImage.disabled = true;
        }
    });
});