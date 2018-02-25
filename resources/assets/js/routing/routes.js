import Login from './../templates/frontend/auth/Login.vue'
import Register from './../templates/frontend/auth/Register.vue'
import Activation from './../templates/frontend/auth/Activation.vue'
import ForgotPassword from './../templates/frontend/auth/password/Forgot.vue'
import ResetPassword from './../templates/frontend/auth/password/Reset.vue'
import Servers from './../templates/frontend/auth/Servers.vue'
import Shop from '../templates/layout/shop/Shop.vue'
import Catalog from '../templates/frontend/shop/catalog/Catalog.vue'
import Cart from '../templates/frontend/shop/cart/Cart.vue'

import BasicSettings from '../templates/admin/control/BasicSettings.vue'
import ProductsList from '../templates/admin/products/List.vue'
import ItemsList from '../templates/admin/items/List.vue'
import NewsList from '../templates/admin/news/List.vue'
import PagesList from '../templates/admin/pages/List.vue'
import UsersList from '../templates/admin/users/List.vue'
import About from '../templates/admin/information/About.vue'

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
        path: '/catalog',
        component: Shop,
        children: [
            {
                path: ':server',
                alias: ':server/0',
                name: 'frontend.shop.catalog',
                components: {
                    content: Catalog
                },
                meta: {
                    title: $t('content.frontend.shop.catalog.title')
                }
            },
            {
                path: ':server/:category',
                name: 'frontend.shop.catalog.category',
                components: {
                    content: Catalog
                },
                meta: {
                    title: $t('content.frontend.shop.catalog.title')
                }
            }
        ],
    },
    {
        path: '/cart',
        component: Shop,
        children: [
            {
                path: ':server',
                name: 'frontend.shop.cart',
                components: {
                    content: Cart
                },
                meta: {
                    title: $t('content.frontend.shop.cart.title')
                }
            },
        ]
    },
    {
        path: '/admin',
        component: Shop,
        children: [
            {
                path: 'control/basic',
                name: 'admin.control.basic',
                components: {
                    content: BasicSettings
                },
                meta: {
                    title: $t('content.admin.control.basic.title')
                }
            },
            {
                path: 'products/list',
                name: 'admin.products.list',
                components: {
                    content: ProductsList
                },
                meta: {
                    title: $t('content.admin.products.list.title')
                }
            },
            {
                path: 'items/list',
                name: 'admin.items.list',
                components: {
                    content: ItemsList
                },
                meta: {
                    title: $t('content.admin.items.list.title')
                }
            },
            {
                path: 'news/list',
                name: 'admin.news.list',
                components: {
                    content: NewsList
                },
                meta: {
                    title: $t('content.admin.news.list.title')
                }
            },
            {
                path: 'pages/list',
                name: 'admin.pages.list',
                components: {
                    content: PagesList
                },
                meta: {
                    title: $t('content.admin.pages.list.title')
                }
            },
            {
                path: 'users/list',
                name: 'admin.users.list',
                components: {
                    content: UsersList
                },
                meta: {
                    title: $t('content.admin.users.list.title')
                }
            },
            {
                path: 'information/about',
                name: 'admin.information.about',
                components: {
                    content: About
                },
                meta: {
                    title: $t('content.admin.information.about.title')
                }
            }
        ]
    }
];
