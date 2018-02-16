import notification from './notification'

export default {
    install(Vue, options) {
        Vue.prototype.$notification = notification;
    }
};
