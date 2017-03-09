/**
 * Responsible for working with alerts
 *
 * @constructor
 */
function Message() {
    /**
     * How much time will be displayed pop-up message (in seconds)
     *
     * @type {number}
     */
    this.duration = 5;

    /**
     * Name of cookie with flash message
     *
     * @type {string}
     */
    this.cookie = 'message';

    /**
     * Unique msg id length
     *
     * @type {number}
     */
    var ID_LENGTH = 4;

    /**
     * @type {Message}
     */
    var self = this;

    /**
     * Display blue message
     *
     * @param text
     * @param duration
     */
    this.info = function (text, duration) {
        var id = genId();
        append('<div class="message message-info ' + id + '"><i class="fa fa-exclamation fa-lg fa-left"></i> ' + text + '</div>');
        timeout(id, duration);
    };

    /**
     * Display green message
     *
     * @param text
     * @param duration
     */
    this.success = function (text, duration) {
        var id = genId();
        append('<div class="message message-success ' + id + '"><i class="fa fa-check fa-lg fa-left"></i> ' + text + '</div>');
        timeout(id, duration);
    };

    /**
     * Display yellow message
     *
     * @param text
     * @param duration
     */
    this.warning = function (text, duration) {
        var id = genId();
        append('<div class="message message-warning ' + id + '"><i class="fa fa-exclamation-triangle fa-lg fa-left"></i> ' + text + '</div>');
        timeout(id, duration);
    };

    /**
     * Display red message
     *
     * @param text
     * @param duration
     */
    this.danger = function (text, duration) {
        var id = genId();
        append('<div class="message message-danger ' + id + '"><i class="fa fa-times fa-lg fa-left"></i> ' + text + '</div>');
        timeout(id, duration);
    };

    /**
     * Append message html into message - box
     *
     * @param {string} content
     */
    function append(content) {
        $('.messages').append(content);
    }

    /**
     * Sets the timeout after which the message will disappear should
     *
     * @param {string} id
     * @param {number} duration
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
     * Generate unique message id
     *
     * @returns {string}
     */
    function genId() {
        return rndStr(ID_LENGTH);
    }
}
