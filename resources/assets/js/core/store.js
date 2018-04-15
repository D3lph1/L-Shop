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
                username: null,
                balance: null
            }
        },
        shop: {
            server: null,
            currency: {
                plain: '',
                html: ''
            },
            cart: {
                amount: 0
            },
            news: {
                enabled: false
            }
        }
    },
    mutations: {
        setCurrencyPlain(state, currency) {
            state.shop.currency.plain = currency;
        },
        setCurrencyHtml(state, currency) {
            state.shop.currency.html = currency;
        },
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
                state.username = null;

                return;
            }

            state.auth.user.username = username;
        },
        logout(state) {
            state.auth.user.username = null;
            state.auth.user.balance = null;
        },
        setBalance(state, balance) {
            state.auth.user.balance = balance;
        },
        setServer(state, server) {
            state.shop.server = server;
        },
        setCartAmount(state, amount) {
            state.shop.cart.amount = amount;
        },
        subCartAmount(state, amount = 1) {
            if (amount >= state.shop.cart.amount) {
                state.shop.cart.amount = 0;

                return;
            }

            state.shop.cart.amount -= amount;
        },
        enableNews(state) {
            state.shop.news.enabled = true;
        },
        disableNews(state) {
            state.shop.news.enabled = false;
        }
    },
    getters: {
        isAuth(state) {
            return state.auth.user.username !== null;
        }
    }
});
