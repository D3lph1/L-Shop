/**
 * JavaScript file with function - helpers declarations.
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @link https://github.com/D3lph1/L-shop
 */

/**
 * @param id
 * @returns {Element}
 */
function byId(id) {
    return document.getElementById(id);
}

/**
 * @param className
 * @returns {NodeList}
 */
function byClass(className) {
    return document.getElementsByClassName(className);
}

/**
 * @param tag
 * @returns {NodeList}
 */
function byTag(tag) {
    return document.getElementsByTagName(tag);
}

/**
 * @param selector
 * @returns {Element}
 */
function bySelector(selector) {
    return document.querySelector(selector);
}

/**
 * @param selector
 * @returns {NodeList}
 */
function bySelectorAll(selector) {
    return document.querySelectorAll(selector);
}

/**
 * Generate a random string
 *
 * @param length
 * @returns {string}
 */
function rndStr(length) {
    var str = '';
    var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    for (var i = 0; i < length; i++)
        str += possible.charAt(Math.floor(Math.random() * possible.length));

    return str;
}

function getToken() {
    return $('meta[name="_token"]').attr('content');
}

function setToken(token) {
    $('meta[name="_token"]').attr('content', token);
}

/**
 * Get the page url
 *
 * @returns {string|undefined}
 */
function url(url) {
    if (url == undefined) {
        return document.location.href;
    }

    document.location.href = url
}

/**
 * Make element disabled
 *
 * @param target
 */
function disable(target) {
    $(target).attr('disabled', 'disabled');
    $(target).addClass('disabled');
}

/**
 * Make element enabled
 *
 * @param target
 */
function enable(target) {
    $(target).prop('disabled', false);
    $(target).removeClass('disabled');
}

/**
 * Set the cookie
 *
 * @param name
 * @param value
 * @param options
 */
function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == 'number' && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + '=' + value;

    for (var propName in options) {
        updatedCookie += '; ' + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}

/**
 * Get the cookie
 *
 * @param name
 * @returns {*}
 */
function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

/**
 * Delete cookie by name
 *
 * @param name
 */
function deleteCookie(name) {
    setCookie(name, '', {
        expires: -10000
    })
}

function getUrlParams() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });

    return vars;
}

/**
 * Display request error message
 */
function requestError(more) {
    msg.danger($('#request-error'));
}

/**
 * Get ReCaptcha response
 *
 * @returns {string}
 */
function getCaptcha() {
    return $('#captcha-form').serialize().split('=')[1];
}

/**
 * Get remember value
 *
 * @param key
 * @returns {*}
 */
function getRemember(key) {
    return remember[key];
}

/**
 * Set remember in cookie.
 *
 * @param key
 * @param value
 */
function setRemember(key, value) {
    remember[key] = value;
    setCookie('lshop_remember', JSON.stringify(remember));
}

function showErrors(errors) {
    if (typeof errors === 'object') {
        for (var property in errors) {
            if (errors.hasOwnProperty(property)) {
                for (i = 0; i < errors.length; i++) {
                    msg.danger(errors[i]);
                }

                showErrors(errors[property]);
            }
        }
    }
}

function complete(xhr) {
    if (xhr.status === 422) {
        var response = JSON.parse(xhr.responseText);
        showErrors(response);
    }
}
