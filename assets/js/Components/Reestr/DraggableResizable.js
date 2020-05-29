export default class DraggableResizable {

    constructor() {
        this.listener();
        this.startY = 0;
        this.startHeight = 0;
    }

    initDrag(e) {
        this.startY = e.clientY;
        this.startHeight = parseInt(document.defaultView.getComputedStyle(this.top).height, 10);
        document.documentElement.addEventListener('mousemove', this.doDrag, false);
        document.documentElement.addEventListener('mouseup', this.stopDrag, false);
    }

    doDrag(e) {
        $(this.top).style.height = (this.startHeight + e.clientY - this.startY) + 'px';
    }

    stopDrag(e) {
        document.documentElement.removeEventListener('mousemove', this.doDrag, false);
        document.documentElement.removeEventListener('mouseup', this.stopDrag, false);
    }

    listener() {
        $('body').on('mousedown', 'i.resize.vertical.icon', this.initDrag);
        $('body').on('mouseup', 'i.resize.vertical.icon', this.initDrag);
    }
}
