<template>
    <v-content>
        <v-container fluid>
            <v-layout align-center justify-center>
                <v-flex xs12 sm5 md4 lg3>
                    <v-card class="elevation-12">
                        <v-toolbar dark color="primary">
                            <v-icon>check_box</v-icon>
                            <v-toolbar-title>{{ $t('content.frontend.auth.servers.title') }}</v-toolbar-title>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                        <v-card-text>
                            <v-list>
                                <v-list-tile avatar v-for="(server, index) in servers" :key="index" @click="$router.push({name: server.route, params: {server: server.id}})">
                                    <v-list-tile-action>
                                        <v-icon v-if="!server.enabled">power_settings_new</v-icon>
                                    </v-list-tile-action>
                                    <v-list-tile-content>
                                        <v-list-tile-title v-text="server.name"></v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>
                            </v-list>
                        </v-card-text>
                        <v-card-actions>
                            <v-layout flex align-center justify-center>
                                <v-btn v-if="isAuth" color="secondary" @click="logout" :loading="disabledLogoutBtn" :disabled="disabledLogoutBtn">{{ $t('content.frontend.auth.login.logout') }}</v-btn>
                                <v-btn v-else-if="!isAuth && allowLogin" :to="{name: 'frontend.auth.login'}" color="secondary">{{ $t('content.frontend.auth.login.login') }}</v-btn>
                            </v-layout>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </v-content>
</template>

<script>
    import loader from './../../../core/http/loader'

    export default {
        data() {
            return {
                servers: [],
                allowLogin: false,

                disabledLogoutBtn: false
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/api/servers', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/api/servers', to, from, next, this);
        },
        computed: {
            disabledBtn() {
                return !this.check();
            },
            isAuth() {
                return this.$store.getters.isAuth;
            }
        },
        methods: {
            logout() {
                this.disabledLogoutBtn = true;
                this.$axios.post('/api/logout')
                    .then((response) => {
                        if (response.data.status === 'success') {
                            this.$notification.info($t('msg.frontend.auth.logout.success'));
                            this.$router.replace({name: 'frontend.auth.login'});
                            this.disabledLogoutBtn = false;
                        }
                    });
            },
            setData(response) {
                const data = response.data;

                this.servers = data.servers;
                this.allowLogin = data.allowLogin;
            }
        }
    }
</script>
