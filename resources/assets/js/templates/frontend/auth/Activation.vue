<template>
    <v-content>
        <v-container fluid fill-height>
            <v-layout align-center justify-center>
                <v-flex xs12 sm5 md4 lg3>
                    <v-card class="elevation-12">
                        <v-toolbar dark color="primary">
                            <v-icon>repeat</v-icon>
                            <v-toolbar-title>{{ $t('content.frontend.auth.activation.sent.title') }}</v-toolbar-title>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                        <v-card-text>
                            <p class="body-1" v-html="$t('content.frontend.auth.activation.sent.description')"></p>

                            <v-form>
                                <v-text-field prepend-icon="mail" v-model="email" :label="$t('validation.attributes.email')" type="text" @keyup.enter="perform"></v-text-field>
                            </v-form>
                            <!--<v-form>
                                <div v-html="captcha"></div>
                            </v-form>-->
                        </v-card-text>
                        <v-card-actions>
                            <v-layout flex align-center justify-center>
                                <v-btn color="primary" :loading="loadingBtn" :disabled="loadingBtn || disabledBtn" @click="perform">{{ $t('content.frontend.auth.activation.sent.repeat') }}</v-btn>
                            </v-layout>
                        </v-card-actions>
                        <v-card-actions class="text-xs-center" v-if="accessModeAny || accessModeAuth">
                            <v-layout flex align-center justify-center>
                                <v-btn flat small color="secondary" :to="{name: 'frontend.auth.login'}">{{ $t('content.frontend.auth.login.title') }}</v-btn>
                            </v-layout>
                        </v-card-actions>
                        <v-card-actions>
                            <v-layout flex align-center justify-center v-if="accessModeAny">
                                <v-btn flat small color="secondary" :to="{name: 'frontend.auth.password.forgot'}">{{ $t('content.frontend.auth.login.purchase_without_auth') }}</v-btn>
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
                email: '',
                loadingBtn: false,

                accessModeAny: false,
                accessModeAuth: false,
                captcha: ''
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/api/activation/sent', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/api/activation/sent', to, from, next, this);
        },
        computed: {
            disabledBtn() {
                return !this.check();
            }
        },
        methods: {
            check() {
                return this.email !== '';
            },
            send() {
                this.loadingBtn = true;
                this.$axios.post('/api/activation/repeat', {
                    email: this.email
                })
                    .then((response) => {
                        let data = response.data;
                        let status = data.status;
                        if (status === 'success') {
                            //
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

                this.accessModeAny = data.accessModeAny;
                this.accessModeAuth = data.accessModeAuth;
                this.captcha = data.captcha;
            }
        }
    }
</script>
