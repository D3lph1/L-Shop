/**
 * The JavaScript file that performs the necessary actions immediately after the page loads
 */

msg = new Message();

remember = getCookie('lshop_remember');
if (!remember) {
    remember = {};
} else {
    remember = JSON.parse(remember);
}

if (getRemember('api_enable')) {
    $('#admin-api-enable-alert-close').parent().hide();
}

if (getRemember('api_docs')) {
    $('#admin-api-docs-alert-close').parent().hide();
}

if (getRemember('security_debug')) {
    $('#admin-security-debug-alert-close').parent().hide();
}

$(document).ready(function () {
    // Hide preloader when the page is ready
    $('#pre-loader').fadeOut();
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

$(function () {
    $('[data-toggle="popover"]').popover()
});
