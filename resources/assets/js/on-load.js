/**
 * The JavaScript file that performs the necessary actions immediately after the page loads
 */

msg = new Message();

$(document).ready(function () {
    // Show the flash message
    msg.flash();
});