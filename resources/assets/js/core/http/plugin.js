import axios from './axios'

/**
 * Vue plugin is used to access an instance of axios from components.
 *
 * @example
 *  // In vue component...
 *  this.$axios
 */
export default {
    install(Vue, options) {
        Vue.prototype.$axios = axios;
    }
};
