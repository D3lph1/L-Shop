<template>
    <v-container
            id="full"
            fluid
            align-center
            justify-center
    >
        <v-card
                id="enter-card"
                width="300px"
        >
            <v-card
                    id="form-header"
                    color="primary"
            >
                <v-icon medium color="white">person_add</v-icon>
                <h1>{{ $t('content.frontend.auth.register.title') }}</h1>
            </v-card>

            <v-form id="form">
                <v-text-field
                        v-model="username"
                        :label="$t('validation.attributes.username')"
                        required
                        prepend-icon="person_outline"
                ></v-text-field>
                <v-text-field
                        v-model="email"
                        :label="$t('validation.attributes.email')"
                        required
                        prepend-icon="mail_outline"
                ></v-text-field>
                <v-text-field
                        v-model="password"
                        :label="$t('validation.attributes.password')"
                        :append-icon-cb="() => (visible = !visible)"
                        :append-icon="visible ? 'visibility' : 'visibility_off'"
                        :type="visible ? 'text' : 'password'"
                        required
                        prepend-icon="lock_outline"
                ></v-text-field>
                <v-text-field
                        v-model="passwordConfirmation"
                        :label="$t('validation.attributes.password_confirmation')"
                        :append-icon-cb="() => (visibleConfirm = !visibleConfirm)"
                        :append-icon="visibleConfirm ? 'visibility' : 'visibility_off'"
                        :type="visibleConfirm ? 'text' : 'password'"
                        required
                        prepend-icon="lock_outline"
                ></v-text-field>
                <v-btn
                        @click="perform"
                        :loading="loadingBtn"
                        :disabled="disabledBtn"
                        block
                        color="primary"
                >
                    {{ $t('content.frontend.auth.register.btn') }}
                </v-btn>
            </v-form>

            <v-footer
                    height="auto"
                    id="form-footer"
            >
                <v-tooltip bottom>
                    <v-btn
                            large
                            outline
                            icon
                            color="green"
                            slot="activator"
                            :to="{name: 'frontend.auth.login'}"
                    >
                        <v-icon>input</v-icon>
                    </v-btn>
                    <span>{{ $t('content.frontend.auth.login.login') }}</span>
                </v-tooltip>

                <v-tooltip bottom>
                    <v-btn
                            large
                            outline
                            icon
                            color="orange"
                            slot="activator"
                            :to="{name: 'frontend.auth.servers'}"
                    >
                        <v-icon>shopping_cart</v-icon>
                    </v-btn>
                    <span>{{ $t('content.frontend.auth.login.purchase_without_auth') }}</span>
                </v-tooltip>
            </v-footer>
        </v-card>
    </v-container>
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
                visible: false,
                visibleConfirm: false,

                accessModeAny: false,
                accessModeAuth: false,
                captcha: ''
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/spa/register', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteEnter('/spa/register', to, from, next, this);
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
                    this.email.match(/.+@.+\..+/i) &&
                    this.password !== '' &&
                    this.passwordConfirmation !== '';
            },
            send() {
                this.loadingBtn = true;
                this.$axios.post('/spa/register', {
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
