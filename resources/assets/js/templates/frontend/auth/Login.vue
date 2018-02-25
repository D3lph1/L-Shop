<template>
    <v-content>
        <v-container fluid fill-height>
            <v-layout align-center justify-center>
                <v-flex xs12 sm5 md4 lg3>
                    <v-card class="elevation-12">
                        <v-toolbar dark color="primary">
                            <v-icon>input</v-icon>
                            <v-toolbar-title>{{ $t('content.frontend.auth.login.title') }}</v-toolbar-title>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                        <v-card-text>
                            <v-form>
                                <v-text-field prepend-icon="person" v-model="username" :label="$t('validation.attributes.username')" type="text" @keyup.enter="perform"></v-text-field>
                                <v-text-field prepend-icon="lock" v-model="password" :label="$t('validation.attributes.password')" type="password" @keyup.enter="perform"></v-text-field>
                            </v-form>
                        </v-card-text>
                        <v-card-actions>
                            <v-layout flex align-center justify-center>
                                <v-btn color="primary" :loading="loadingBtn" :disabled="disabledBtn" @click="perform">{{ $t('content.frontend.auth.login.login') }}</v-btn>
                            </v-layout>
                        </v-card-actions>
                        <v-card-actions class="text-xs-center" v-if="enabledRegister && !onlyForAdmins">
                            <v-layout flex align-center justify-center>
                                <v-btn flat small color="secondary" :to="{name: 'frontend.auth.register'}">{{ $t('content.frontend.auth.register.title') }}</v-btn>
                            </v-layout>
                        </v-card-actions>
                        <v-card-actions>
                            <v-layout flex align-center justify-center v-if="enabledPasswordReset">
                                <v-btn flat small color="secondary" :to="{name: 'frontend.auth.password.forgot'}">{{ $t('content.frontend.auth.login.forgot_password') }}</v-btn>
                            </v-layout>
                        </v-card-actions>
                        <v-card-actions>
                            <v-layout flex align-center justify-center  v-if="accessModeAny">
                                <v-btn flat small color="secondary" :to="{name: 'frontend.auth.servers'}">{{ $t('content.frontend.auth.login.purchase_without_auth') }}</v-btn>
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
                username: '',
                password: '',
                loadingBtn: false,

                onlyForAdmins: false,
                accessModeAny: false,
                downForMaintenance: false,
                enabledPasswordReset: false,
                enabledRegister: false
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/api/login', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/api/login', to, from, next, this);
        },
        computed: {
            disabledBtn() {
                return !this.check();
            }
        },
        methods: {
            check() {
                this.username = this.username.trim();
                return this.username.length !== 0 && this.password.length !== 0;
            },
            send() {
                this.loadingBtn = true;
                this.$axios.post('/api/login', {
                    username: this.username,
                    password: this.password
                })
                    .then((response) => {
                        let data = response.data;
                        let status = data.status;
                        if (status === 'success') {
                            this.$router.replace({name: 'frontend.auth.servers'});

                            return;
                        }
                        this.loadingBtn = false;
                    })
                    .catch((err) => {
                        this.loadingBtn = false;
                    });
            },
            perform() {
                if (!this.check()) {
                    return;
                }
                this.send();
            },
            setData(response) {
                const data = response.data;

                this.enabledRegister = data.enabledRegister;
                this.onlyForAdmins = data.onlyForAdmins;
                this.enabledPasswordReset = data.enabledPasswordReset;
                this.accessModeAny = data.accessModeAny;
                this.downForMaintenance = data.downForMaintenance;
                this.enabledPasswordReset = data.enabledPasswordReset;
                this.enabledRegister = data.enabledRegister;
            }
        }
    }
</script>
