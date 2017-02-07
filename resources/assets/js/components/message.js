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
    this.duration = 4;

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
        append('<div class="alert alert-info ' + id + '"><i class="fa fa-exclamation fa-lg fa-left"></i> ' + text + '</div>');
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
        append('<div class="alert alert-success ' + id + '"><i class="fa fa-check fa-lg fa-left"></i> ' + text + '</div>');
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
        append('<div class="alert alert-warning ' + id + '"><i class="fa fa-exclamation-triangle fa-lg fa-left"></i> ' + text + '</div>');
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
        append('<div class="alert alert-danger ' + id + '"><i class="fa fa-times fa-lg fa-left"></i> ' + text + '</div>');
        timeout(id, duration);
    };

    /**
     * Set info message in cookie
     *
     * @param text
     */
    this.setInfo = function (text) {
        set('info', text);
    };

    /**
     * Set success message in cookie
     *
     * @param text
     */
    this.setSuccess = function (text) {
        set('success', text);
    };

    /**
     * Set warning message in cookie
     *
     * @param text
     */
    this.setWarning = function (text) {
        set('warning', text);
    };

    /**
     * Set danger message in cookie
     *
     * @param text
     */
    this.setDanger = function (text) {
        set('danger', text);
    };

    /**
     * Show flash message from cookie
     */
    this.flash = function () {
        var cookie = getFromCookie();
        if (cookie) {
            self[getMsgType(cookie)](getMsgText(cookie));
            // Since flash message should be displayed once, clean the cookie in which it is stored
            deleteCookie(this.cookie);
        }
    };

    /**
     * Get flash message type
     *
     * @param {string} content
     * @returns {string}
     */
    function getMsgType(content) {
        return content.split('::')[0];
    }

    /**
     * Get flash message text
     *
     * @param {string} content
     * @returns {string}
     */
    function getMsgText(content) {
        return content.split('::')[1];
    }

    /**
     * Get flash message from cookie
     *
     * @returns {string} {*}
     */
    function getFromCookie() {
        return getCookie(self.cookie);
    }

    /**
     * Set flash message in cookie
     *
     * @param {string} type
     * @param {string} text
     */
    function set(type, text) {
        text = text.split('::').join('');
        setCookie('message', type + '::' + text);
    }

    /**
     * Append message html into message - box
     *
     * @param {string} content
     */
    function append(content) {
        $('.alerts').append(content);
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
