<template>
    <div>
        <v-toolbar flat v-if="$store.getters.isAuth">
            <v-toolbar-title id="drawer-username">
                <v-icon>person_outline</v-icon>
                <span>{{ $store.state.auth.user.username }}</span>
            </v-toolbar-title>
        </v-toolbar>

        <v-list class="pt-0 pb-0" subheader>
            <v-divider></v-divider>
            <v-subheader>Магазин</v-subheader>

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
            <v-list-tile v-else @click="$router.push({name: 'frontend.auth.login' })">
                <v-list-tile-action>
                    <v-icon>vpn_key</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>{{ $t('content.frontend.auth.login.login') }}</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list>
    </div>
</template>

<script>
    export default {
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

<style lang="less" scoped>
    #drawer-username {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin: 0;
        span {
            margin-left: 10px;
        }
    }
</style>
