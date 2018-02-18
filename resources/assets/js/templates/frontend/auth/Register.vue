<template>
    <v-content>
        <v-container fluid fill-height>
            <v-layout align-center justify-center>
                <v-flex xs12 sm5 md4 lg3>
                    <v-card class="elevation-12">
                        <v-toolbar dark color="primary">
                            <v-icon>add</v-icon>
                            <v-toolbar-title>{{ $t('content.frontend.auth.register.title') }}</v-toolbar-title>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                        <v-card-text>
                            <v-form>
                                <v-text-field prepend-icon="person" v-model="username" :label="$t('validation.attributes.username')" type="text" @keyup.enter="perform"></v-text-field>
                                <v-text-field prepend-icon="mail" v-model="email" :label="$t('validation.attributes.email')" type="text" @keyup.enter="perform"></v-text-field>
                                <v-text-field
                                        prepend-icon="lock"
                                        v-model="password"
                                        :append-icon="p1 ? 'visibility' : 'visibility_off'"
                                        :append-icon-cb="() => (p1 = !p1)"
                                        :label="$t('validation.attributes.password')"
                                        :type="p1 ? 'password' : 'text'"
                                        @keyup.enter="perform"
                                ></v-text-field>
                                <v-text-field
                                        prepend-icon="lock"
                                        v-model="passwordConfirmation"
                                        :append-icon="p2 ? 'visibility' : 'visibility_off'"
                                        :append-icon-cb="() => (p2 = !p2)"
                                        :label="$t('validation.attributes.password_confirmation')"
                                        :type="p2 ? 'password' : 'text'"
                                        @keyup.enter="perform"
                                ></v-text-field>
                            </v-form>
                            <!--<v-form>
                                <div v-html="captcha"></div>
                            </v-form>-->
                        </v-card-text>
                        <v-card-actions>
                            <v-layout flex align-center justify-center>
                                <v-btn color="primary" :loading="loadingBtn" :disabled="loadingBtn || disabledBtn" @click="perform">{{ $t('content.frontend.auth.login.login') }}</v-btn>
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
                username: '',
                email: '',
                password: '',
                passwordConfirmation: '',
                loadingBtn: false,
                p1: true,
                p2: true,

                accessModeAny: false,
                accessModeAuth: false,
                captcha: ''
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/api/register', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteEnter('/api/register', to, from, next, this);
        },
        computed: {
            disabledBtn() {
                return !this.check();
            }
        },
        methods: {
            check() {
                return this.username !== '' &&
                    this.email !== '' &&
                    this.password !== '' &&
                    this.passwordConfirmation !== '';
            },
            send() {
                this.loadingBtn = true;
                this.$axios.post('/api/register', {
                    username: this.username,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.passwordConfirmation
                })
                    .then((response) => {
                        let data = response.data;
                        let status = data.status;
                        if (status === 'success') {
                            this.$router.push({name: data.redirect});
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

<style scoped>

</style>