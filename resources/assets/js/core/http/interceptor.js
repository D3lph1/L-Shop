import axios from './axios'
import store from './../store'
import router from './../../routing/router'
import notification from './../notification/notification'

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

        if (typeof data.status !== 'undefined') {
            // The "auth" status means that the page is not accessible to the user
            // and needs to be authorized.
            if (data.status === 'auth') {
                notification.warning($t('msg.only_for_auth'));
                router.push({name: 'frontend.auth.login'});

                // An empty promise since processing a query does not make sense.
                // Because the user will redirect.
                return new Promise(() => {});
            } else if (data.status === 'guest') {
                // The "guest" status means that the page is only available to authorized users.

                router.push({name: 'frontend.auth.servers'});

                // An empty promise since processing a query does not make sense.
                // Because the user will redirect.
                return new Promise(() => {});
            }
        }
    }

    return response;
}, (err) => {
    // Show internal error notification.
    if (err.response.status === 500) {
        notification.error($t('msg.request_error.title'));
    } else if (err.response.status === 422) {
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
    }

    return err;
});
