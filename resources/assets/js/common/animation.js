export default class Animation {
    static fadeOut(element, duration) {
        let seconds = duration / 1000;
        element.style.transition = 'opacity ' + seconds + 's ease';

        element.style.opacity = 0;
        setTimeout(function () {
            element.parentNode.removeChild(element);
        }, duration);
    }
}
