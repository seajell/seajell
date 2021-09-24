// Most of these code are taken from the interact.js documentation.
const position = { x: 0, y: 0 }
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
                `translate(${position.x}px, ${position.y}px)`
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
            width: `${event.rect.width}px`,
            height: `${event.rect.height}px`,
            transform: `translate(${x}px, ${y}px)`
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
            `translate(${position.x}px, ${position.y}px)`
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
            width: `${event.rect.width}px`,
            height: `${event.rect.height}px`,
            transform: `translate(${x}px, ${y}px)`
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
            `translate(${position.x}px, ${position.y}px)`
        },
    }
});
