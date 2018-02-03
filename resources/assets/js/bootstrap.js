/**
 * This file loads the application elements.
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @link https://github.com/D3lph1/L-shop
 */

import './../css/bootstrap.min.css'
import './../css/mdb.min.css'
import './../css/font-awesome.min.css'
import './../css/main.css'
import './../sass/main.sass'

import 'bootstrap'
import './lib/mdb.min'
import './lib/trumbowyg/trumbowyg.min'
import './localization'
import Message from './common/message'
import Captcha from './common/captcha';

window.msg = new Message();
window.captcha = new Captcha('#captcha-form');

// Set global error handler for Axios.
axios.interceptors.response.use(function (response) {
    const data = response.data;

    if (typeof data !== 'undefined' && typeof data.notifications !== 'undefined') {
        const notifications = data.notifications;
        for (let key in notifications) {
            if (notifications.hasOwnProperty(key)) {
                let notification = notifications[key];
                msg.call(notification.type, notification.content);
            }
        }
    }

    return response;
}, function (err) {
    if (err.response.status === 500) {
        msg.danger($t('msg.request_error'));
    } else if (err.response.status === 422) {
        const errors = err.response.data.errors;
        for (let key in errors) {
            if (errors.hasOwnProperty(key)) {
                msg.danger(errors[key]);
            }
        }
    }

    return err.response;
});

addEventListener('DOMContentLoaded', function () {
    // If is shop page.
    if (document.getElementById('content')) {
        document.getElementById('content').style.width = 'calc(100% - ' + document.getElementById('sidebar').clientWidth + 'px)';
        document.getElementById('content').style.marginLeft = document.getElementById('sidebar').clientWidth + 'px';

        let badHeight = Math.floor(document.getElementById('topbar').clientHeight + document.getElementById('footer').clientHeight);
        document.getElementById('content-container').style.minHeight = 'calc(100vh - ' + badHeight + 'px)';

        document.getElementById('side-content').style.width = document.getElementById('sidebar').clientWidth + 'px';

        /**
         * Sidebar on mobile
         */
        document.getElementById('btn-menu').onclick = () => {
            document.getElementById('side-content').style.transform = 'translateX(0)';
        };

        document.getElementById('btn-menu-c').onclick = () => {
            document.getElementById('side-content').style.transform = 'translateX(-100%)';
        };

        document.getElementById('btn-menu').onclick = () => {
            document.getElementById('side-content').style.transform = 'translateX(0)';
        };

        document.getElementById('btn-menu-c').onclick = () => {
            document.getElementById('side-content').style.transform = 'translateX(-100%)';
        };

        $('.product-container').hide().eq(0).show();

        $('.cat-btn').click(function () {
            let tabNumber = $(this).index();
            let pc = $('.product-container');
            if (pc.eq(tabNumber).css('display') === 'none') {
                pc.eq(tabNumber).siblings().hide();
                $(this).siblings().css({'background-color': '#ffbb33'});
                $(this).css({'background-color': '#FF8800'});
                pc.eq(tabNumber).fadeIn();
            }
        });

        if (document.getElementById('news-content') !== null) {
            let scrollWidth = document.getElementById('news-content').offsetWidth - document.getElementById('news-content').clientWidth;

            document.getElementById('news-content').style.marginRight = -scrollWidth + 'px';

            document.getElementById('btn-news').addEventListener('click', () => {
                document.getElementById('news-content').style.transform = 'translateX(0)';
            });

            document.getElementById('news-back').addEventListener('click', () => {
                document.getElementById('news-content').style.transform = 'translateX(100%)';
            });
        }
    }
});
