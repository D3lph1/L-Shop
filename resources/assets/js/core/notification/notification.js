import store from '../store'

export default {
    success(content) {
        store.commit('addNotification', {type: 'success', content});
    },
    info(content) {
        store.commit('addNotification', {type: 'info', content});
    },
    warning(content) {
        store.commit('addNotification', {type: 'warning', content});
    },
    error(content) {
        store.commit('addNotification', {type: 'error', content});
    },
    call(type, content) {
        store.commit('addNotification', {type, content});
    }
}
