import "./bootstrap";
import Vue from 'vue'
import Vuex from 'vuex'
import ProfileBlock from './components/layout/sidebar/ProfileBlock.vue'
import CollapseBlock from './components/layout/sidebar/CollapseBlock.vue'
import ServersBlock from './components/layout/sidebar/ServersBlock.vue'
import NewsBlock from './components/layout/NewsBlock.vue'
import CatalogItem from './components/shop/CatalogItem.vue'
import QuickPurchaseModal from './components/shop/QuickPurchaseModal.vue'
import Login from './components/auth/Login.vue'
import Register from './components/auth/Register.vue'
import Activation from './components/auth/Activation.vue'
import ForgotPassword from './components/auth/ForgotPassword.vue'
import ResetPassword from './components/auth/ResetPassword.vue'
import SelectServer from './components/auth/SelectServer.vue'

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        isAuth: false,
        balance: 0,
        cartCount: 0,
        purchasable: {
            name: null,
            price: 0,
            stack: 0,
            url: null
        }
    },
    mutations: {
        setAuth(state, val) {
            state.isAuth = val;
        },
        setBalance(state, sum) {
            state.balance = Math.abs(sum);
        },
        addBalance(state, sum) {
            state.balance += Math.abs(sum);
        },
        subBalance(state, sum) {
            state.balance -= Math.abs(sum);
        },
        setCartCount(state, count) {
            state.cartCount = Math.abs(count);
        },
        putInCart(state, count = 1) {
            state.cartCount += Math.abs(count);
        },
        removeFromCart(state, count = 1) {
            state.cartCount -= Math.abs(count);
        },
        quickPurchase(state, {name, price, stack, url}) {
            state.purchasable.name = name;
            state.purchasable.price = price;
            state.purchasable.stack = stack;
            state.purchasable.url = url;
        }
    }
});

const app = new Vue({
    el: '#app',
    store,
    data: {
        //
    },
    components: {
        'login': Login,
        'register': Register,
        'activation': Activation,
        'forgot-password': ForgotPassword,
        'reset-password': ResetPassword,
        'select-server': SelectServer,

        'profile-block': ProfileBlock,
        'collapse-block': CollapseBlock,
        'servers-block': ServersBlock,
        'news-block': NewsBlock,
        'catalog-item': CatalogItem,
        'quick-purchase-modal': QuickPurchaseModal
    }
});

// Init trumbowyg.
(() => {
    let pc = $('#page-content');
    if (pc) {
        pc.trumbowyg({
            lang: 'ru'
        });
    }
})();
