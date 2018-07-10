import axios from './axios'
import store from './../store'
import router from './../../routing/router'
import notification from './../notification/notification'

/**
 * Configuring the axios response spoiler. The response interceptor is a function
 * that is called before the response is processed in the then() and catch().
 */
axios.interceptors.response.use((response) => {
    const data = response.data;

    if (typeof data !== 'undefined') {
        if (typeof data.notifications !== 'undefined') {
            // Show notification of the incoming together with the request.
            // Example of structure:
            // [
            //     {
            //          'type': 'notification type', // Semantic type of notification.
            //                                       // Supported: 'success', 'info', 'warning', 'error'
            //          'content': 'notification text'
            //     },
            //     ...
            // ]
            const notifications = data.notifications;
            for (let key in notifications) {
                if (notifications.hasOwnProperty(key)) {
                    let each = notifications[key];
                    notification.call(each.type, each.content);
                }
            }
        }

        // If the auth element exists, it means that the user is authorized.
        if (typeof data.auth !== 'undefined') {
            // Set authorization session in storage.
            store.commit('setAuth', data.auth.username);
        }

        if (data.early_redirect) {
            router.push({name: data.early_redirect, params: data.early_redirect_params});
        }

        if (data.status === 'guest') {
            router.push({name: 'frontend.index'});
        }
    }

    return response;
}, (err) => {
    // Show relevant error.
    if (err.response.status === 500 && err.response.config.method === 'get') {
        router.replace({name: 'error.500'});
    } else if (err.response.status === 500) {
        // Show internal error notification.
        notification.error($t('msg.request_error.title'));
    } else if (err.response.status === 503 && err.response.config.method === 'get') {
        router.replace({name: 'error.503'});
    } else if (err.response.status === 403 && err.response.config.method === 'get') {
        router.replace({name: 'error.403'});
    } else if (err.response.status === 404 && err.response.config.method === 'get') {
        router.replace({name: 'error.404'});
    } else {
        // Show validation error notification.
        // Example of structure:
        // {
        //      'attribute name': [
        //           'validation error',
        //           'validation error'
        //      ],
        //      ...
        // }
        //
        // Learn more in Laravel documentation.
        const errors = err.response.data.errors;
        for (let subError in errors) {
            if (errors.hasOwnProperty(subError)) {
                for (let error in errors[subError]) {
                    if (errors[subError].hasOwnProperty(error)) {
                        notification.error(errors[subError][error]);
                    }
                }
            }
        }

        // Show notifications. Read more on line 11.
        const notifications = err.response.data.notifications;
        for (let key in notifications) {
            if (notifications.hasOwnProperty(key)) {
                let each = notifications[key];
                notification.call(each.type, each.content);
            }
        }

        // If an early redirect element is present in the response, it makes an
        // immediate redirect.
        if (err.response.data.early_redirect) {
            router.push({name: err.response.data.early_redirect, params: err.response.early_redirect_params});
        }
    }

    return err;
});
