import Animation from './animation'
import Rnd from './rnd'

export default class Message {
    constructor() {
        /**
         * How much time will be displayed pop-up message (in seconds).
         *
         * @type {number}
         */
        this.duration = 5;

        /**
         * Unique msg id length.
         *
         * @type {number}
         */
        this.ID_LENGTH = 4;
    }

    /**
     * Display blue message.
     *
     * @param {string} text Text of message.
     */
    info(text) {
        let id = this.genId();
        this.append(`<div class="message message-info ${id}"><i class="fa fa-exclamation fa-lg fa-left"></i> ${text} </div>`);
        this.timeout(id, this.duration);
    };

    /**
     * Display green message.
     *
     * @param {string} text Text of message.
     */
    success(text) {
        let id = this.genId();
        this.append(`<div class="message message-success ${id}"><i class="fa fa-check fa-lg fa-left"></i> ${text} </div>`);
        this.timeout(id, this.duration);
    };

    /**
     * Display yellow message.
     *
     * @param {string} text Text of message.
     */
    warning(text) {
        let id = this.genId();
        this.append(`<div class="message message-warning ${id}"><i class="fa fa-exclamation-triangle fa-lg fa-left"></i> ${text} </div>`);
        this.timeout(id, this.duration);
    };

    /**
     * Display red message.
     *
     * @param {string} text Text of message.
     */
    danger(text) {
        let id = this.genId();
        this.append(`<div class="message message-danger ${id}"><i class="fa fa-times fa-lg fa-left"></i> ${text} </div>`);
        this.timeout(id, this.duration);
    };

    /**
     * @param {string} type Type of message (info, success, warning, danger).
     * @param {string} text Text of message.
     */
    call(type, text) {
        type = type.toLowerCase();
        switch(type) {
            case 'info':
                this.info(text);
                return;
            case 'success':
                this.success(text);
                return;
            case 'warning':
                this.warning(text);
                return;
            case 'danger':
                this.danger(text);
                return;
        }

        throw new Error('Invalid type of message function (' + type + ').');
    };

    /**
     * @param {number} duration Duration of displaying message.
     */
    setDuration(duration) {
        this.duration = duration;
    };

    /**
     * Append message html into message - box.
     *
     * @param {string} content
     */
    append(content) {
        let el = document.getElementsByClassName('messages')[0];
        el.innerHTML = el.innerHTML + content;
    }

    /**
     * Sets the timeout after which the message will disappear should.
     *
     * @param {string} id Unique identifier of message block.
     * @param {number} duration Duration of displaying message.
     */
    timeout(id, duration = this.duration) {
        duration = Number(duration);

        setTimeout(function () {
            Animation.fadeOut(document.getElementsByClassName(id)[0], 500);
        }, duration * 1000);
    }

    /**
     * Generate unique message id.
     *
     * @returns {string}
     */
    genId() {
        return Rnd.Str(this.ID_LENGTH);
    }
}
