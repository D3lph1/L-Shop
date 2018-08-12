<template>
    <v-list class="pt-0 pb-0" subheader>
        <v-subheader>{{ $t('content.layout.shop.sidebar.basic.title') }}</v-subheader>

        <v-list-tile ripple :to="toCatalog()">
            <v-list-tile-action>
                <v-icon>view_module</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>{{ $t('content.layout.shop.sidebar.basic.catalog') }}</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
        <v-list-tile ripple :to="toCart()">
            <v-list-tile-action>
                <v-badge color="secondary" v-model="cartBadge" overlap right>
                    <span slot="badge">{{ cartAmount }}</span>
                    <v-icon>shopping_cart</v-icon>
                </v-badge>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>{{ $t('content.layout.shop.sidebar.basic.cart') }}</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
        <v-list-tile @click="$router.push({name: 'frontend.auth.servers'})">
            <v-list-tile-action>
                <v-icon>keyboard_backspace</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>{{ $t('content.layout.shop.sidebar.basic.servers') }}</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
        <v-list-tile v-if="$store.getters.isAuth" @click="logout">
            <v-list-tile-action>
                <v-icon>exit_to_app</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>{{ $t('content.frontend.auth.login.logout') }}</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
        <v-list-tile v-if="accessModeAny && !$store.getters.isAuth" @click="$router.push({name: 'frontend.auth.login' })">
            <v-list-tile-action>
                <v-icon>vpn_key</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>{{ $t('content.frontend.auth.login.login') }}</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
    </v-list>
</template>

<script>
    export default {
        props: {
            accessModeAny: {
                required: true,
                type: Boolean
            }
        },
        computed: {
            cartBadge() {
                return Boolean(this.$store.state.shop.cart.amount);
            },
            cartAmount() {
                return this.$store.state.shop.cart.amount;
            }
        },
        methods: {
            logout() {
                this.$axios.post('/spa/logout')
                    .then((response) => {
                        if (response.data.status === 'success') {
                            this.$notification.info($t('msg.frontend.auth.logout.success'));
                            this.$store.commit('logout');
                        }
                        this.$router.replace({name: 'frontend.auth.login'});
                    })
                    .catch(error => {
                        this.$router.replace({name: 'frontend.auth.login'});
                    });
            },
            toCatalog() {
                if (!this.$store.state.shop.server) {
                    return {name: 'frontend.auth.servers'};
                } else {
                    return {name: 'frontend.shop.catalog', params: {server: this.$store.state.shop.server.id}};
                }
            },
            toCart() {
                if (!this.$store.state.shop.server) {
                    return {name: 'frontend.auth.servers'};
                } else {
                    return {name: 'frontend.shop.cart', params: {server: this.$store.state.shop.server.id}};
                }
            }
        }
    }
</script>
