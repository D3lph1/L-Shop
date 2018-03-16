import Vue from './core/bootstrap'
import Vuex from 'vuex'

import './components'
import router from './routing/router'
import store from './core/store'

Vue.use(Vuex);

new Vue({
    el: '#app',
    router,
    store
});
