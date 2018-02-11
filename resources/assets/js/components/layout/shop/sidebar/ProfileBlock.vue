<template>
    <div>
        <p v-if="isAuth" id="name">{{ username }}</p>
        <div id="profile-block">
            <p v-if="isAuth" id="balance"><i class="fa fa-database fa-left"></i>
                {{ $t('sidebar.main.balance') }}:
                <span id="balance-span">
                    {{ this.$store.state.balance }}
                </span>
                <span v-html="currency"></span>
            </p>
            <a :href="routeCatalog" class="btn info-color btn-block">
                <i class="fa fa-list fa-lg fa-left"></i>
                {{ $t('sidebar.main.catalog') }}
            </a>
            <a :href="routeCart" class="btn info-color btn-block">
                <i class="fa fa-shopping-cart fa-left fa-lg"></i>
                {{ $t('sidebar.main.cart') }}
                <span class="badge badge-pill info-color text-white z-depth-0">{{ cart }}</span>
            </a>
            <a v-if="isAuth" :href="fillupbalanceUrl" class="btn btn-warning btn-block">
                <i class="fa fa-credit-card fa-left fa-lg"></i>
                {{ $t('sidebar.main.fillupbalance') }}
            </a>
            <a v-if="isAuth" :href="routeLogout" class="btn danger-color btn-block">
                <i class="fa fa-times fa-left fa-lg"></i>
                {{ $t('sidebar.main.logout') }}
            </a>
            <a v-if="canLogin" :href="routeLogin" class="btn btn-warning btn-block">
                <i class="fa fa-key fa-left fa-lg"></i>
                {{ $t('sidebar.main.signin') }}
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'isAuth', 'username', 'balance', 'currency', 'routeCatalog', 'routeCart', 'cartCount',
            'fillupbalanceUrl', 'routeLogout', 'canLogin', 'routeLogin'
        ],
        computed: {
            cart() {
                return this.$store.state.cart.amount;
            }
        },
        mounted() {
            this.$store.commit('setAuth', this.isAuth);
            this.$store.commit('setCartCount', this.cartCount);
            this.$store.commit('addBalance', this.balance);
        }
    }
</script>
