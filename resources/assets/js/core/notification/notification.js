import store from '../store'

/**
 * The object below contains functions for displaying notifications.
 */
export default {
    /**
     * Display success notification. Color by default - green.
     *
     * @param {String} content. Text of notification.
     */
    success(content) {
        store.commit('addNotification', {type: 'success', content});
    },
    /**
     * Display info notification. Color by default - blue.
     *
     * @param {String} content. Text of notification.
     */
    info(content) {
        store.commit('addNotification', {type: 'info', content});
    },
    /**
     * Display warning notification. Color by default - yellow.
     *
     * @param {String} content. Text of notification.
     */
    warning(content) {
        store.commit('addNotification', {type: 'warning', content});
    },
    /**
     * Display error notification. Color by default - red.
     *
     * @param {String} content. Text of notification.
     */
    error(content) {
        store.commit('addNotification', {type: 'error', content});
    },
    /**
     * Displays the notification of a given type.
     *
     * @param {String} type. Available by default: "success", "info", "warning", "error".
     * @param {String} content. Text of notification.
     *
     * @example
     *  // Show warning notifications.
     *  call('warning', 'This is warning notification!');
     */
    call(type, content) {
        store.commit('addNotification', {type, content});
    }
}
