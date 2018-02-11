import "./bootstrap";
import Vue from 'vue'
import Vuex from 'vuex'
import VChip from 'v-chip'

import ProfileBlock from './components/layout/shop/sidebar/ProfileBlock.vue'
import CollapseBlock from './components/layout/shop/sidebar/CollapseBlock.vue'
import ServersBlock from './components/layout/shop/sidebar/ServersBlock.vue'
import NewsBlock from './components/layout/shop/news/Block.vue'
import CatalogItem from './components/shop/catalog/Item.vue'
import QuickPurchaseModal from './components/shop/catalog/QuickPurchaseModal.vue'
import Cart from './components/shop/cart/Cart.vue'
import Login from './components/auth/Login.vue'
import Register from './components/auth/Register.vue'
import Activation from './components/auth/Activation.vue'
import ForgotPassword from './components/auth/ForgotPassword.vue'
import ResetPassword from './components/auth/ResetPassword.vue'
import SelectServer from './components/auth/SelectServer.vue'
import SkinBlock from './components/shop/profile/Skin.vue'
import CloakBlock from './components/shop/profile/Cloak.vue'
import BasicPage from './components/admin/control/Basic.vue'

import Slider from './components/common/Slider.vue'

Vue.use(Vuex);

Vue.use(VChip);

Vue.component('slider', Slider);

const store = new Vuex.Store({
    state: {
        isAuth: false,
        balance: 0,
        cart: {
            amount: 0,
            cost: 0
        },
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
            state.cart.amount = Math.abs(count);
        },
        putInCart(state, count = 1) {
            state.cart.amount += Math.abs(count);
        },
        removeFromCart(state, count = 1) {
            state.cart.amount -= Math.abs(count);
        },
        addCartCost(state, cost) {
            state.cart.cost += Math.abs(cost);
        },
        subCartCost(state, cost) {
            state.cart.cost -= Math.abs(cost);
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
        'quick-purchase-modal': QuickPurchaseModal,
        'cart': Cart,

        'skin-block': SkinBlock,
        'cloak-block': CloakBlock,

        'basic-page': BasicPage
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
