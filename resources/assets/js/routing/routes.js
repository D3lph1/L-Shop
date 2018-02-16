import Login from './../templates/frontend/auth/Login.vue'
import Register from './../templates/frontend/auth/Register.vue'
import Activation from './../templates/frontend/auth/Activation.vue'
import ForgotPassword from './../templates/frontend/auth/password/Forgot.vue'
import ResetPassword from './../templates/frontend/auth/password/Reset.vue'
import Servers from './../templates/frontend/auth/Servers.vue'
import Catalog from '../templates/layout/shop/Shop.vue'

export default [
    {
        path: '/login',
        name: 'frontend.auth.login',
        component: Login,
        meta: {
            title: $t('content.frontend.auth.login.title')
        }
    },
    {
        path: '/register',
        name: 'frontend.auth.register',
        component: Register,
        meta: {
            title: $t('content.frontend.auth.register.title')
        }
    },
    {
        path: '/activation/sent',
        name: 'frontend.auth.activation.sent',
        component: Activation,
        mata: {
            title: $t('content.frontend.auth.activation.sent.title')
        }
    },
    {
        path: '/password/forgot',
        name: 'frontend.auth.password.forgot',
        component: ForgotPassword,
        meta: {
            title: $t('content.frontend.auth.password.forgot.title')
        }
    },
    {
        path: '/password/reset/:code',
        name: 'frontend.auth.password.reset',
        component: ResetPassword,
        meta: {
            title: $t('content.frontend.auth.password.reset.title')
        }
    },
    {
        path: '/servers',
        name: 'frontend.auth.servers',
        component: Servers,
        meta: {
            title: $t('content.frontend.auth.servers.title')
        }
    },
    {
        path: '/catalog/:server',
        name: 'frontend.shop.catalog',
        component: Catalog
    }
];
