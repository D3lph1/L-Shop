/**
 * Below is the declaration of system vue routes.
 * The meta title field serves to specify the header that the route page will have.
 */

const Login = () => import(/* webpackChunkName: "shop" */ './../templates/frontend/auth/Login.vue');
const Register = () => import(/* webpackChunkName: "shop" */ './../templates/frontend/auth/Register.vue');
const Activation = () => import(/* webpackChunkName: "shop" */ './../templates/frontend/auth/Activation.vue');
const ForgotPassword = () => import(/* webpackChunkName: "shop" */ './../templates/frontend/auth/password/Forgot.vue');
const ResetPassword = () => import(/* webpackChunkName: "shop" */ './../templates/frontend/auth/password/Reset.vue');
const Servers = () => import(/* webpackChunkName: "shop" */ './../templates/frontend/auth/Servers.vue');
const Shop = () => import(/* webpackChunkName: "shop" */ '../templates/layout/shop/Shop.vue');
const Catalog = () => import(/* webpackChunkName: "shop" */ '../templates/frontend/shop/catalog/Catalog.vue');
const Cart = () => import(/* webpackChunkName: "shop" */ '../templates/frontend/shop/cart/Cart.vue');
const Payment = () => import(/* webpackChunkName: "shop" */ '../templates/frontend/shop/Payment.vue');
const Character = () => import(/* webpackChunkName: "shop" */ '../templates/frontend/profile/Character.vue');
const ProfileSettings = () => import(/* webpackChunkName: "shop" */ '../templates/frontend/profile/Settings.vue');
const ProfilePurchases = () => import(/* webpackChunkName: "shop" */ '../templates/frontend/profile/Purchases.vue');
const ProfileCart = () => import(/* webpackChunkName: "shop" */ '../templates/frontend/profile/Cart.vue');
const News = () => import(/* webpackChunkName: "shop" */ '../templates/frontend/news/News.vue');
const Page = () => import(/* webpackChunkName: "shop" */ '../templates/frontend/Page.vue');

const BasicSettings = () => import(/* webpackChunkName: "admin" */ '../templates/admin/control/BasicSettings.vue');
const PaymentsSettings = () => import(/* webpackChunkName: "admin" */ '../templates/admin/control/Payments.vue');
const Security = () => import(/* webpackChunkName: "admin" */ '../templates/admin/control/Security.vue');
const Optimization = () => import(/* webpackChunkName: "admin" */ '../templates/admin/control/Optimization.vue');
const ProductsAdd = () => import(/* webpackChunkName: "admin" */ '../templates/admin/products/Add.vue');
const ProductsEdit = () => import(/* webpackChunkName: "admin" */ '../templates/admin/products/Edit.vue');
const ProductsList = () => import(/* webpackChunkName: "admin" */ '../templates/admin/products/List.vue');
const ItemsAdd = () => import(/* webpackChunkName: "admin" */ '../templates/admin/items/Add.vue');
const ItemsEdit = () => import(/* webpackChunkName: "admin" */ '../templates/admin/items/Edit.vue');
const ItemsList = () => import(/* webpackChunkName: "admin" */ '../templates/admin/items/List.vue');
const NewsList = () => import(/* webpackChunkName: "admin" */ '../templates/admin/news/List.vue');
const PagesAdd = () => import(/* webpackChunkName: "admin" */ '../templates/admin/pages/Add.vue');
const PagesEdit = () => import(/* webpackChunkName: "admin" */ '../templates/admin/pages/Edit.vue');
const PagesList = () => import(/* webpackChunkName: "admin" */ '../templates/admin/pages/List.vue');
const UsersList = () => import(/* webpackChunkName: "admin" */ '../templates/admin/users/List.vue');
const UsersEdit = () => import(/* webpackChunkName: "admin" */ '../templates/admin/users/Edit.vue');
const Rcon = () => import(/* webpackChunkName: "admin" */ '../templates/admin/other/Rcon.vue');
const Debug = () => import(/* webpackChunkName: "admin" */ '../templates/admin/other/Debug.vue');
const StatisticShow = () => import(/* webpackChunkName: "admin" */ '../templates/admin/statistic/Show.vue');
const StatisticPurchases = () => import(/* webpackChunkName: "admin" */ '../templates/admin/statistic/Purchases.vue');
const About = () => import(/* webpackChunkName: "admin" */'../templates/admin/information/About.vue');

export default [
    {
        path: '/',
        name: 'frontend.index',
        redirect: {name: 'frontend.auth.servers'}
    },
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
        meta: {
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
                redirect: ':server/0',
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
        path: '/payment',
        component: Shop,
        children: [
            {
                path: ':purchase',
                name: 'frontend.shop.payment',
                components: {
                    content: Payment
                },
                meta: {
                    title: $t('content.frontend.shop.payment.title')
                }
            },
        ]
    },
    {
        path: '/profile',
        component: Shop,
        children: [
            {
                path: 'character',
                name: 'frontend.profile.character',
                components: {
                    content: Character
                },
                meta: {
                    title: $t('content.frontend.profile.character.title')
                }
            },
            {
                path: 'settings',
                name: 'frontend.profile.settings',
                components: {
                    content: ProfileSettings
                },
                meta: {
                    title: $t('content.frontend.profile.settings.title')
                }
            },
            {
                path: 'purchases',
                name: 'frontend.profile.purchases',
                components: {
                    content: ProfilePurchases
                },
                meta: {
                    title: $t('content.frontend.profile.purchases.title')
                }
            },
            {
                path: 'cart',
                name: 'frontend.profile.cart',
                components: {
                    content: ProfileCart
                },
                meta: {
                    title: $t('content.frontend.profile.cart.title')
                }
            },
        ]
    },
    {
        path: '/news',
        component: Shop,
        children: [
            {
                path: ':news',
                name: 'frontend.news',
                components: {
                    content: News
                }
            }
        ]
    },
    {
        path: '/page',
        component: Shop,
        children: [
            {
                path: ':url',
                name: 'frontend.page',
                components: {
                    content: Page
                }
            }
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
                path: 'control/payments',
                name: 'admin.control.payments',
                components: {
                    content: PaymentsSettings
                },
                meta: {
                    title: $t('content.admin.control.payments.title')
                }
            },
            {
                path: 'control/security',
                name: 'admin.control.security',
                components: {
                    content: Security
                },
                meta: {
                    title: $t('content.admin.control.security.title')
                }
            },
            {
                path: 'control/optimization',
                name: 'admin.control.optimization',
                components: {
                    content: Optimization
                },
                meta: {
                    title: $t('content.admin.control.optimization.title')
                }
            },
            {
                path: 'products/add',
                name: 'admin.products.add',
                components: {
                    content: ProductsAdd
                },
                meta: {
                    title: $t('content.admin.products.add.title')
                }
            },
            {
                path: 'products/edit/:product',
                name: 'admin.products.edit',
                components: {
                    content: ProductsEdit
                },
                meta: {
                    title: $t('content.admin.products.edit.title')
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
                path: 'items/add',
                name: 'admin.items.add',
                components: {
                    content: ItemsAdd
                },
                meta: {
                    title: $t('content.admin.items.add.title')
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
                path: 'items/edit/:item',
                name: 'admin.items.edit',
                components: {
                    content: ItemsEdit
                },
                meta: {
                    title: $t('content.admin.items.edit.title')
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
                path: 'pages/add',
                name: 'admin.pages.add',
                components: {
                    content: PagesAdd
                },
                meta: {
                    title: $t('content.admin.pages.add.title')
                }
            },
            {
                path: 'pages/edit/:page',
                name: 'admin.pages.edit',
                components: {
                    content: PagesEdit
                },
                meta: {
                    title: $t('content.admin.pages.edit.title')
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
                path: 'users/edit/:user',
                name: 'admin.users.edit',
                components: {
                    content: UsersEdit
                },
                meta: {
                    title: $t('content.admin.users.edit.main.title')
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
                path: 'other/rcon',
                name: 'admin.other.rcon',
                components: {
                    content: Rcon
                },
                meta: {
                    title: $t('content.admin.other.rcon.title')
                }
            },
            {
                path: 'other/debug',
                name: 'admin.other.debug',
                components: {
                    content: Debug
                },
                meta: {
                    title: $t('content.admin.other.debug.title')
                }
            },
            {
                path: 'statistic/show',
                name: 'admin.statistic.show',
                components: {
                    content: StatisticShow
                },
                meta: {
                    title: $t('content.admin.statistic.show.title')
                }
            },
            {
                path: 'statistic/purchases',
                name: 'admin.statistic.purchases',
                components: {
                    content: StatisticPurchases
                },
                meta: {
                    title: $t('content.admin.statistic.purchases.title')
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
