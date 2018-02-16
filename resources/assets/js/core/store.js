import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        // If the value is true on the page, the loading indicator.
        loading: false,
        notifications: [],
        // If the value is true on the page, the "request error" dialog box is displayed.
        requestError: false,
        auth: {
            user: {
                username: null
            }
        }
    },
    mutations: {
        startLoading(state) {
            state.loading = true;
        },
        stopLoading(state) {
            state.loading = false;
        },
        addNotification(state, {type, content}) {
            state.notifications.push({
                createdAt: Date.now(),
                type,
                content
            });

            const maxLifespan = 5000;

            setInterval(function checkItems(){
                state.notifications.forEach(function(item){
                    if(Date.now() - maxLifespan > item.createdAt){
                        state.notifications.shift() // remove first item
                    }
                })
            }, 1000)
        },
        requestError(state) {
            state.requestError = true;
        },
        dismissRequestError(state) {
            state.requestError = false;
        },
        setAuth(state, username) {
            if (typeof username !== 'string') {
                throw TypeError(`username must be type of string, ${typeof username} given`)
            }

            state.auth.user.username = username;
        }
    },
    getters: {
        isAuth(state) {
            return state.auth.user.username !== null;
        }
    }
});
