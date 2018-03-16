import notification from './notification'

/**
 * This vue plugin is used to quickly access an instance of notifications in components.
 * @example
 *  // In vue component...
 *  this.$notification
 */
export default {
    install(Vue, options) {
        Vue.prototype.$notification = notification;
    }
};
