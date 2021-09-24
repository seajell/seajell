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
 */
