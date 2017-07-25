/**
 * Responsible for working with alerts.
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @link https://github.com/D3lph1/L-shop
 *
 * @constructor
 */
function Message() {
    /**
     * How much time will be displayed pop-up message (in seconds).
     *
     * @type {number}
     */
    this.duration = 5;

    /**
     * Name of cookie with flash message.
     *
     * @type {string}
     */
    this.cookie = 'message';

    /**
     * Unique msg id length.
     *
     * @type {number}
     */
    var ID_LENGTH = 4;

    /**
     * @type {Message}
     */
    var self = this;

    /**
     * Display blue message.
     *
     * @param {string} text Text of message.
     */
    this.info = function (text) {
        var id = genId();
        append('<div class="message message-info ' + id + '"><i class="fa fa-exclamation fa-lg fa-left"></i> ' + text + '</div>');
        timeout(id, self.duration);
    };

    /**
     * Display green message.
     *
     * @param {string} text Text of message.
     */
    this.success = function (text) {
        var id = genId();
        append('<div class="message message-success ' + id + '"><i class="fa fa-check fa-lg fa-left"></i> ' + text + '</div>');
        timeout(id, self.duration);
    };

    /**
     * Display yellow message.
     *
     * @param {string} text Text of message.
     */
    this.warning = function (text) {
        var id = genId();
        append('<div class="message message-warning ' + id + '"><i class="fa fa-exclamation-triangle fa-lg fa-left"></i> ' + text + '</div>');
        timeout(id, self.duration);
    };

    /**
     * Display red message.
     *
     * @param {string} text Text of message.
     */
    this.danger = function (text) {
        var id = genId();
        append('<div class="message message-danger ' + id + '"><i class="fa fa-times fa-lg fa-left"></i> ' + text + '</div>');
        timeout(id, self.duration);
    };

    /**
     * @param {string} type Type of message (info, success, warning, danger).
     * @param {string} text Text of message.
     */
    this.call = function(type, text) {
        var f = this[type];

        if (typeof f === 'function') {
            f(text);

            return;
        }

        throw new Error('Invalid type of message function (' + type + ').');
    };

    /**
     * @param {number} duration Duration of displaying message.
     */
    this.setDuration = function (duration) {
        self.duration = duration;
    };

    /**
     * Append message html into message - box.
     *
     * @param {string} content
     */
    function append(content) {
        $('.messages').append(content);
    }

    /**
     * Sets the timeout after which the message will disappear should.
     *
     * @param {string} id Unique identifier of message block.
     * @param {number} duration Duration of displaying message.
     */
    function timeout(id, duration) {
        // Normalize duration value
        if (!duration) {
            duration = self.duration;
        }
        duration = Number(duration);

        setTimeout(function () {
            $('.' + id).fadeOut(500);
        }, duration * 1000);
    }

    /**
     * Generate unique message id.
     *
     * @returns {string}
     */
    function genId() {
        return rndStr(ID_LENGTH);
    }
}
