export default class Captcha {
    constructor(selector) {
        this.selector = selector;
    }

    getToken() {
        return document.querySelector(this.selector).elements[0].value;
    }
}
