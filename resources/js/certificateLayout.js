/**
 * Dragging and resizing objects
 */

// Most of these code are taken from the interact.js documentation.
const position = { x: 0, y: 0 }

// Formula for converting px to mm
// mm = ( px * 25.4 ) / DPI
// I'm just gonna assume the DPI is 96 (which isn't the case for every devices), so the final formula is
// mm = ( px * 25.4 ) / 96

interact('.draggable-resizable-square').draggable({
    // keep the element within the area of it's parent
    modifiers: [
        interact.modifiers.restrictRect({
          restriction: 'parent',
          endOnly: true
        })
    ],
    listeners: {
        move (event) {
            position.x += event.dx
            position.y += event.dy

            event.target.style.transform =
                `translate(${( position.x * 25.4 ) / 96 }mm, ${( position.y * 25.4 ) / 96 }mm)`
        },
    }
}).resizable({
    edges: { top: true, left: false, bottom: true, right: true },
    invert: 'reposition',
    listeners: {
        move: function (event) {
            let { x, y } = event.target.dataset

            x = (parseFloat(x) || 0) + event.deltaRect.left
            y = (parseFloat(y) || 0) + event.deltaRect.top

            Object.assign(event.target.style, {
            width: `${( event.rect.width * 25.4 ) / 96}mm`,
            height: `${( event.rect.height * 25.4 ) / 96}mm`,
            transform: `translate(${( x * 25.4 ) / 96}mm, ${( y * 25.4 ) / 96}mm)`
            })

            Object.assign(event.target.dataset, { x, y })
        }
    },
    modifiers: [
        // Maintains the aspect ration
        interact.modifiers.aspectRatio({
            ratio: 1,
        }),
    ]
});

interact('.draggable-resizable-rectangle').draggable({
    // keep the element within the area of it's parent
    modifiers: [
        interact.modifiers.restrictRect({
          restriction: 'parent',
          endOnly: true
        })
    ],
    listeners: {
        move (event) {
        position.x += event.dx
        position.y += event.dy

        event.target.style.transform =
            `translate(${( position.x * 25.4 ) / 96}mm, ${( position.y * 25.4 ) / 96}mm)`
        },
    }
}).resizable({
    edges: { top: true, left: false, bottom: true, right: true },
    invert: 'reposition',
    listeners: {
        move: function (event) {
            let { x, y } = event.target.dataset

            x = (parseFloat(x) || 0) + event.deltaRect.left
            y = (parseFloat(y) || 0) + event.deltaRect.top

            Object.assign(event.target.style, {
            width: `${( event.rect.width * 25.4 ) / 96}mm`,
            height: `${( event.rect.height * 25.4 ) / 96}mm`,
            transform: `translate(${( x * 25.4 ) / 96}mm, ${( y * 25.4 ) / 96}mm)`
            })

            Object.assign(event.target.dataset, { x, y })
        }
    },
    modifiers: [
        // Maintains the aspect ration
        interact.modifiers.aspectRatio({
            ratio: 2,
        }),
    ]
});

// This is for details
interact('.draggable-resizable').draggable({
    // keep the element within the area of it's parent
    modifiers: [
        interact.modifiers.restrictRect({
          restriction: 'parent',
          endOnly: true
        })
    ],
    listeners: {
        move (event) {
            position.x += event.dx
            position.y += event.dy

            event.target.style.transform =
                `translate(${( position.x * 25.4 ) / 96 }mm, ${( position.y * 25.4 ) / 96 }mm)`
        },
    }
}).resizable({
    edges: { top: true, left: false, bottom: true, right: true },
    invert: 'reposition',
    listeners: {
        move: function (event) {
            let { x, y } = event.target.dataset

            x = (parseFloat(x) || 0) + event.deltaRect.left
            y = (parseFloat(y) || 0) + event.deltaRect.top

            Object.assign(event.target.style, {
            width: `${( event.rect.width * 25.4 ) / 96}mm`,
            height: `${( event.rect.height * 25.4 ) / 96}mm`,
            transform: `translate(${( x * 25.4 ) / 96}mm, ${( y * 25.4 ) / 96}mm)`
            })

            Object.assign(event.target.dataset, { x, y })
        }
    }
});

// This is for the QR Code box
interact('.draggable-rectangle').draggable({
    // keep the element within the area of it's parent
    modifiers: [
        interact.modifiers.restrictRect({
          restriction: 'parent',
          endOnly: true
        })
    ],
    listeners: {
        move (event) {
        position.x += event.dx
        position.y += event.dy

        event.target.style.transform =
            `translate(${( position.x * 25.4 ) / 96}mm, ${( position.y * 25.4 ) / 96}mm)`
        },
    }
});

/**
 *  Inserting values into save layout form
 *
 * The flow:
 * - Admin click the save button.
 * - Width, height and translate is added into the form in the confirmation modal.
 * JS will check whether the objects is available (logos, detail, signatures and qr code box).
 * - Admin click the confirm button to submit the form through POST request.
 * - Controller does its magic.
 */

const saveBtn = document.querySelector('#save-btn');
const logoFirstElement = document.querySelector('#logo-first');
const logoSecondElement = document.querySelector('#logo-second');
const logoThirdElement = document.querySelector('#logo-third');
const detailsElement = document.querySelector('#details');
const signatureFirstElement = document.querySelector('#signature-first');
const signatureSecondElement = document.querySelector('#signature-second');
const signatureThirdElement = document.querySelector('#signature-third');
const qrCodeElement = document.querySelector('#qr-code');

saveBtn.addEventListener('click', () => {
    // Check if elements exist

    // Logos
    if(logoFirstElement){
        // Width and height
        let logoFirstElementWidth = logoFirstElement.style.width;
        let logoFirstElementHeight = logoFirstElement.style.height;
        let logoFirstInputWidth = document.querySelector('#logo-first-input-width');
        let logoFirstInputHeight = document.querySelector('#logo-first-input-height');
        logoFirstInputWidth.value = logoFirstElementWidth;
        logoFirstInputHeight.value = logoFirstElementHeight;

        // XY Translate
        let logoFirstElementTranslate = logoFirstElement.style.transform;
        let logoFirstInputTranslate = document.querySelector('#logo-first-input-translate');
        logoFirstInputTranslate.value = logoFirstElementTranslate;
    }

    if(logoSecondElement){
        // Width and height
        let logoSecondElementWidth = logoSecondElement.style.width;
        let logoSecondElementHeight = logoSecondElement.style.height;
        let logoSecondInputWidth = document.querySelector('#logo-second-input-width');
        let logoSecondInputHeight = document.querySelector('#logo-second-input-height');
        logoSecondInputWidth.value = logoSecondElementWidth;
        logoSecondInputHeight.value = logoSecondElementHeight;

        // XY Translate
        let logoSecondElementTranslate = logoSecondElement.style.transform;
        let logoSecondInputTranslate = document.querySelector('#logo-second-input-translate');
        logoSecondInputTranslate.value = logoSecondElementTranslate;
    }

    if(logoThirdElement){
        // Width and height
        let logoThirdElementWidth = logoThirdElement.style.width;
        let logoThirdElementHeight = logoThirdElement.style.height;
        let logoThirdInputWidth = document.querySelector('#logo-third-input-width');
        let logoThirdInputHeight = document.querySelector('#logo-third-input-height');
        logoThirdInputWidth.value = logoThirdElementWidth;
        logoThirdInputHeight.value = logoThirdElementHeight;

        // XY Translate
        let logoThirdElementTranslate = logoThirdElement.style.transform;
        let logoThirdInputTranslate = document.querySelector('#logo-third-input-translate');
        logoThirdInputTranslate.value = logoThirdElementTranslate;
    }

    // Details
    if(detailsElement){
        // Width and height
        let detailsElementWidth = detailsElement.style.width;
        let detailsElementHeight = detailsElement.style.height;
        let detailsInputWidth = document.querySelector('#details-input-width');
        let detailsInputHeight = document.querySelector('#details-input-height');
        detailsInputWidth.value = detailsElementWidth;
        detailsInputHeight.value = detailsElementHeight;

        // XY Translate
        let detailsElementTranslate = detailsElement.style.transform;
        let detailsInputTranslate = document.querySelector('#details-input-translate');
        detailsInputTranslate.value = detailsElementTranslate;
    }

    // Signatures
    if(signatureFirstElement){
        // Width and height
        let signatureFirstElementWidth = signatureFirstElement.style.width;
        let signatureFirstElementHeight = signatureFirstElement.style.height;
        let signatureFirstInputWidth = document.querySelector('#signature-first-input-width');
        let signatureFirstInputHeight = document.querySelector('#signature-first-input-height');
        signatureFirstInputWidth.value = signatureFirstElementWidth;
        signatureFirstInputHeight.value = signatureFirstElementHeight;

        // XY Translate
        let signatureFirstElementTranslate = signatureFirstElement.style.transform;
        let signatureFirstInputTranslate = document.querySelector('#signature-first-input-translate');
        signatureFirstInputTranslate.value = signatureFirstElementTranslate;
    }

    if(signatureSecondElement){
        // Width and height
        let signatureSecondElementWidth = signatureSecondElement.style.width;
        let signatureSecondElementHeight = signatureSecondElement.style.height;
        let signatureSecondInputWidth = document.querySelector('#signature-second-input-width');
        let signatureSecondInputHeight = document.querySelector('#signature-second-input-height');
        signatureSecondInputWidth.value = signatureSecondElementWidth;
        signatureSecondInputHeight.value = signatureSecondElementHeight;

        // XY Translate
        let signatureSecondElementTranslate = signatureSecondElement.style.transform;
        let signatureSecondInputTranslate = document.querySelector('#signature-second-input-translate');
        signatureSecondInputTranslate.value = signatureSecondElementTranslate;
    }

    if(signatureThirdElement){
        // Width and height
        let signatureThirdElementWidth = signatureThirdElement.style.width;
        let signatureThirdElementHeight = signatureThirdElement.style.height;
        let signatureThirdInputWidth = document.querySelector('#signature-third-input-width');
        let signatureThirdInputHeight = document.querySelector('#signature-third-input-height');
        signatureThirdInputWidth.value = signatureThirdElementWidth;
        signatureThirdInputHeight.value = signatureThirdElementHeight;

        // XY Translate
        let signatureThirdElementTranslate = signatureThirdElement.style.transform;
        let signatureThirdInputTranslate = document.querySelector('#signature-third-input-translate');
        signatureThirdInputTranslate.value = signatureThirdElementTranslate;
    }

    // QR Code
    if(qrCodeElement){
        // XY Translate
        let qrCodeElementTranslate = qrCodeElement.style.transform;
        let qrCodeInputTranslate = document.querySelector('#qr-code-input-translate');
        qrCodeInputTranslate.value = qrCodeElementTranslate;
    }

});
