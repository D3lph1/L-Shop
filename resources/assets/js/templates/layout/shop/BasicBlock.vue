<template>
    <div>
        <v-toolbar flat class="transparent" v-if="$store.getters.isAuth">
            <v-list class="pa-0">
                <v-list-tile avatar>
                    <v-list-tile-content>
                        <v-list-tile-title>
                            <v-layout row wrap align-center>
                                <v-flex class="text-xs-center">
                                    {{ $store.state.auth.user.username }}
                                </v-flex>
                            </v-layout>
                        </v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-toolbar>
        <v-list class="pt-0" dense>
            <v-divider></v-divider>
            <v-list-tile @click="$router.push({name: 'frontend.shop.catalog', params: {server: $route.params.server}})">
                <v-list-tile-action>
                    <v-icon>view_module</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>{{ $t('content.layout.shop.sidebar.basic.catalog') }}</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile @click="">
                <v-list-tile-action>
                    <v-icon>shopping_cart</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>{{ $t('content.layout.shop.sidebar.basic.cart') }}</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <div v-if="$store.getters.isAuth">
                <v-divider></v-divider>
                <v-list-tile @click="logout">
                    <v-list-tile-action>
                        <v-icon>exit_to_app</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>{{ $t('content.frontend.auth.login.logout') }}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-divider></v-divider>
            </div>
            <div v-else>
                <v-divider></v-divider>
                <v-list-tile @click="$router.push({name: 'frontend.auth.login' })">
                    <v-list-tile-action>
                        <v-icon>vpn_key</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>{{ $t('content.frontend.auth.login.login') }}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-divider></v-divider>
            </div>
        </v-list>
    </div>
</template>

<script>
    export default {
        methods: {
            logout() {
                this.$axios.post('/api/logout')
                    .then((response) => {
                        if (response.data.status === 'success') {
                            this.$notification.info($t('msg.frontend.auth.logout.success'));
                            this.$router.replace({name: 'frontend.auth.login'});
                        }
                    });
            }
        }
    }
</script>
